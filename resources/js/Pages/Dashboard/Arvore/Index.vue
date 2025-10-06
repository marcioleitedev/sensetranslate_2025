<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <div class="dashboard-layout">
    <!-- Botão Menu Mobile -->
    <button class="btn btn-primary d-md-none toggle-btn" @click="showMobileMenu = !showMobileMenu">
      <i class="bi bi-list"></i>
    </button>

    <!-- Menu Lateral -->
    <MenuLateral :showMobileMenu="showMobileMenu" @update:showMobileMenu="showMobileMenu = $event" />

    <!-- Conteúdo Principal -->
    <div class="dashboard-content">
      <!-- Header da Página -->
      <div class="page-header">
        <div class="header-content">
          <div class="header-info">
            <h1 class="page-title">
              <i class="bi bi-diagram-3-fill"></i>
              Árvore Genealógica
            </h1>
            <p class="page-subtitle">Serviço: {{ service.name || 'Carregando...' }}</p>
          </div>
          <div class="header-actions">
            <button class="btn-add" @click="openCreateModal">
              <i class="bi bi-person-plus"></i>
              Cadastrar Membro
            </button>
          </div>
        </div>
      </div>

      <!-- Controles e Configurações -->
      <div class="controls-section">
        <div class="tree-stats">
          <div class="stat-item">
            <strong>{{ genealogy.length }}</strong>
            <span>Membros</span>
          </div>
          <div class="stat-item">
            <strong>{{ countAntepassados }}</strong>
            <span>Antepassados</span>
          </div>
          <div class="stat-item">
            <strong>{{ countRequerentes }}</strong>
            <span>Requerentes</span>
          </div>
        </div>
        
        <div class="pdf-controls">
          <h4><i class="bi bi-file-pdf"></i> Configurações PDF</h4>
          <div class="pdf-settings">
            <div class="setting-group">
              <label>
                <i class="bi bi-fonts"></i>
                Tamanho da Fonte
              </label>
              <input
                type="number"
                v-model="pdfSettings.fontSize"
                min="8"
                max="24"
                class="form-input"
                placeholder="12"
              />
            </div>
            <div class="setting-group">
              <label>
                <i class="bi bi-aspect-ratio"></i>
                Largura do Box
              </label>
              <input
                type="number"
                v-model="pdfSettings.boxWidth"
                min="100"
                max="500"
                class="form-input"
                placeholder="200"
              />
            </div>
            <a
              :href="`/dashboard/pdf/${serviceId}?fontSize=${pdfSettings.fontSize}&boxWidth=${pdfSettings.boxWidth}`"
              class="btn-pdf"
              target="_blank"
              rel="noopener"
            >
              <i class="bi bi-file-pdf"></i>
              Visualizar PDF
            </a>
          </div>
        </div>
      </div>

      <!-- Árvore Genealógica -->
      <div class="tree-section">
        <div v-if="nodes.length > 0" class="tree-container">
          <div class="tree">
            <ul>
              <TreeNode 
                v-for="node in nodes" 
                :key="node.id" 
                :node="node" 
                @edit="openEditModal" 
                @delete="deleteMember" 
              />
            </ul>
          </div>
        </div>

        <!-- Estado Vazio -->
        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class="bi bi-diagram-3"></i>
          </div>
          <h3>Nenhum membro cadastrado</h3>
          <p>Comece construindo sua árvore genealógica adicionando o primeiro membro</p>
          <button class="btn-add" @click="openCreateModal">
            <i class="bi bi-person-plus"></i>
            Cadastrar Primeiro Membro
          </button>
        </div>
      </div>

      <!-- Modal de Cadastro/Edição -->
      <div v-if="showModal" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2>
              <i class="bi" :class="form.id ? 'bi-pencil-square' : 'bi-person-plus'"></i>
              {{ form.id ? 'Editar Membro' : 'Cadastrar Membro' }}
            </h2>
            <button class="modal-close" @click="closeModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <!-- Dados Principais -->
              <div class="form-section">
                <h3><i class="bi bi-person"></i> Dados Principais</h3>
                
                <div class="form-group">
                  <label class="form-label">
                    <i class="bi bi-tag"></i>
                    Nome Completo
                  </label>
                  <input 
                    type="text" 
                    v-model="form.name" 
                    class="form-input" 
                    placeholder="Digite o nome completo"
                    required 
                  />
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">
                      <i class="bi bi-diagram-2"></i>
                      Tipo
                    </label>
                    <select v-model="form.type" class="form-select" required>
                      <option value="">Selecione o tipo</option>
                      <option value="1">Antepassado</option>
                      <option value="2">Requerente</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="form-label">
                      <i class="bi bi-person-badge"></i>
                      Menor de Idade
                    </label>
                    <select v-model="form.smaller" class="form-select">
                      <option value="0">Não</option>
                      <option value="1">Sim</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label">
                    <i class="bi bi-arrow-up"></i>
                    Origem (Pai/Mãe)
                  </label>
                  <select v-model="form.origin" class="form-select">
                    <option value="">Sem origem (Raiz da árvore)</option>
                    <option v-for="member in genealogy" :key="member.id" :value="member.name">
                      {{ member.name }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Dados Opcionais -->
              <div class="form-section">
                <h3><i class="bi bi-info-circle"></i> Dados Opcionais</h3>
                
                <div class="form-group">
                  <label class="form-label">
                    <i class="bi bi-geo-alt"></i>
                    Nascido em (Nato in)
                  </label>
                  <input 
                    type="text" 
                    v-model="form.nato" 
                    class="form-input" 
                    placeholder="Cidade, País"
                  />
                </div>

                <div class="form-group">
                  <label class="form-label">
                    <i class="bi bi-calendar-event"></i>
                    Data de Nascimento (Il)
                  </label>
                  <input 
                    type="date" 
                    v-model="form.il" 
                    class="form-input"
                  />
                </div>

                <div class="form-group">
                  <label class="form-label">
                    <i class="bi bi-heart"></i>
                    Casamento com (Dal Matrimonio com)
                  </label>
                  <input 
                    type="text" 
                    v-model="form.matrimonio" 
                    class="form-input" 
                    placeholder="Nome do cônjuge"
                  />
                </div>
              </div>

              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeModal">
                  <i class="bi bi-x-circle"></i>
                  Cancelar
                </button>
                <button type="submit" class="btn-save">
                  <i class="bi bi-check-circle"></i>
                  {{ form.id ? 'Atualizar' : 'Cadastrar' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Variáveis CSS */
:root {
  --primary-color: #e2b560;
  --secondary-color: #2c3e50;
  --accent-color: #3498db;
  --success-color: #27ae60;
  --warning-color: #f39c12;
  --danger-color: #e74c3c;
  --info-color: #3498db;
  --text-dark: #2c3e50;
  --text-light: #7f8c8d;
  --border-radius: 15px;
  --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.15);
}

/* Layout Principal */
.dashboard-layout {
  display: flex;
  min-height: 100vh;
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
}

.dashboard-content {
  flex: 1;
  margin-left: 250px;
  padding: 2rem;
  min-height: 100vh;
}

/* Header da Página */
.page-header {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: var(--border-radius);
  padding: 2rem;
  margin-bottom: 2rem;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2rem;
}

.page-title {
  font-size: 2rem !important;
  font-weight: 700 !important;
  margin: 0 0 0.5rem 0 !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.75rem !important;
  color: black !important;
}

.page-title i {
  font-size: 1.8rem !important;
  color: black !important;
}

.page-subtitle {
  font-size: 1rem !important;
  margin: 0 !important;
  opacity: 0.9 !important;
  color: black !important;
}

.btn-add {
  background: black !important;
  color: white !important;
  border: 2px solid black !important;
  padding: 0.75rem 1.5rem !important;
  border-radius: 25px !important;
  font-weight: 600 !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  transition: all 0.3s ease !important;
  cursor: pointer !important;
  text-decoration: none !important;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
}

.btn-add:hover {
  background: #333333 !important;
  border-color: #333333 !important;
  color: white !important;
  transform: translateY(-2px) !important;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
}

/* Controles */
.controls-section {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 2rem;
  margin-bottom: 2rem;
}

.tree-stats {
  background: white;
  padding: 1.5rem;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  display: flex;
  gap: 1rem;
  align-items: center;
}

.stat-item {
  text-align: center;
  padding: 0.75rem 1rem;
  background: var(--primary-color);
  color: white;
  border-radius: 10px;
  font-weight: 600;
  flex: 1;
}

.stat-item strong {
  display: block;
  font-size: 1.5rem;
  margin-bottom: 0.25rem;
}

.stat-item span {
  font-size: 0.85rem;
  opacity: 0.9;
}

/* PDF Controls */
.pdf-controls {
  background: white;
  padding: 1.5rem;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
}

.pdf-controls h4 {
  margin: 0 0 1rem 0;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.1rem;
}

.pdf-settings {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 1rem;
  align-items: end;
}

.setting-group label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
}

.btn-pdf {
  background: #dc3545 !important;
  color: white !important;
  border: none !important;
  padding: 0.75rem 1.5rem !important;
  border-radius: 8px !important;
  font-weight: 600 !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  text-decoration: none !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
  white-space: nowrap;
}

.btn-pdf:hover {
  background: #c82333 !important;
  transform: translateY(-1px) !important;
}

/* Tree Section */
.tree-section {
  background: white;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  min-height: 500px;
}

.tree-container {
  padding: 2rem;
  overflow-x: auto;
}

.tree {
  min-width: max-content;
}

/* Estado Vazio */
.empty-state {
  text-align: center;
  padding: 4rem 2rem;
}

.empty-icon {
  font-size: 4rem !important;
  color: var(--text-light) !important;
  margin-bottom: 1rem !important;
}

.empty-state h3 {
  color: var(--text-dark) !important;
  margin-bottom: 0.5rem !important;
  font-size: 1.5rem !important;
  font-weight: 600 !important;
}

.empty-state p {
  color: var(--text-light) !important;
  margin-bottom: 2rem !important;
  font-size: 1.1rem !important;
}

/* Modais */
.modal-overlay {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  background: rgba(0, 0, 0, 0.7) !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  z-index: 9999 !important;
  backdrop-filter: blur(5px) !important;
}

.modal-content {
  background: white !important;
  border-radius: var(--border-radius) !important;
  box-shadow: var(--shadow-hover) !important;
  max-width: 700px !important;
  width: 90% !important;
  max-height: 90vh !important;
  overflow-y: auto !important;
  position: relative !important;
  z-index: 10000 !important;
}

.modal-header {
  padding: 2rem 2rem 1rem;
  border-bottom: 1px solid #f1f1f1;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h2 {
  margin: 0 !important;
  color: var(--text-dark) !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  font-size: 1.5rem !important;
  font-weight: 600 !important;
}

.modal-close {
  background: none !important;
  border: none !important;
  font-size: 1.5rem !important;
  color: var(--text-light) !important;
  cursor: pointer !important;
  padding: 0.25rem !important;
  border-radius: 50% !important;
  transition: all 0.3s ease !important;
}

.modal-close:hover {
  background: #f1f1f1 !important;
  color: var(--text-dark) !important;
}

.modal-body {
  padding: 2rem;
}

/* Form Sections */
.form-section {
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: #f8f9fa;
  border-radius: 12px;
  border: 1px solid #e9ecef;
}

.form-section h3 {
  margin: 0 0 1.5rem 0;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.2rem;
  font-weight: 600;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid var(--primary-color);
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.form-label {
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  font-weight: 600 !important;
  color: var(--text-dark) !important;
  margin-bottom: 0.5rem !important;
  font-size: 0.95rem !important;
}

.form-input,
.form-select {
  width: 100% !important;
  padding: 0.75rem !important;
  border: 2px solid #e9ecef !important;
  border-radius: 10px !important;
  font-size: 1rem !important;
  transition: all 0.3s ease !important;
  background: white !important;
  color: var(--text-dark) !important;
}

.form-input:focus,
.form-select:focus {
  outline: none !important;
  border-color: var(--primary-color) !important;
  box-shadow: 0 0 0 3px rgba(226, 181, 96, 0.1) !important;
}

.modal-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
  justify-content: flex-end;
  padding-top: 1rem;
  border-top: 1px solid #e9ecef;
}

.btn-cancel {
  background: #f8f9fa !important;
  color: var(--text-dark) !important;
  border: 2px solid #e9ecef !important;
  padding: 0.75rem 1.5rem !important;
  border-radius: 8px !important;
  font-weight: 600 !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
}

.btn-cancel:hover {
  background: #e9ecef !important;
  border-color: #dee2e6 !important;
}

.btn-save {
  background: var(--success-color) !important;
  color: white !important;
  border: none !important;
  padding: 0.75rem 1.5rem !important;
  border-radius: 8px !important;
  font-weight: 600 !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
}

.btn-save:hover {
  background: #218838 !important;
  transform: translateY(-1px) !important;
}

/* Toggle Button */
.toggle-btn {
  position: fixed;
  top: 15px;
  left: 15px;
  z-index: 1100;
  background: var(--primary-color) !important;
  border: none !important;
  border-radius: 10px !important;
  box-shadow: var(--shadow);
}

/* Responsividade */
@media (max-width: 992px) {
  .dashboard-content {
    margin-left: 0;
    padding: 1.5rem;
  }
  
  .header-content {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
  
  .controls-section {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .pdf-settings {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .form-row {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .page-title {
    font-size: 1.5rem !important;
  }
  
  .tree-stats {
    flex-direction: column;
  }
  
  .modal-content {
    width: 95% !important;
    margin: 1rem !important;
  }
  
  .modal-header,
  .modal-body {
    padding: 1rem;
  }
  
  .form-section {
    padding: 1rem;
  }
}

/* Estilos específicos para árvore genealógica */
.tree ul {
  padding-top: 20px;
  position: relative;
  transition: all 0.5s;
  list-style: none;
  margin: 0;
}

.tree li {
  float: left;
  text-align: center;
  list-style: none;
  position: relative;
  padding: 20px 5px 0 5px;
  transition: all 0.5s;
}

.tree li::before,
.tree li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 2px solid var(--primary-color);
  width: 50%;
  height: 20px;
}

.tree li::after {
  right: auto;
  left: 50%;
  border-left: 2px solid var(--primary-color);
}

.tree li:only-child::after,
.tree li:only-child::before {
  display: none;
}

.tree li:only-child {
  padding-top: 0;
}

.tree li:first-child::before,
.tree li:last-child::after {
  border: 0 none;
}

.tree li:last-child::before {
  border-right: 2px solid var(--primary-color);
  border-radius: 0 5px 0 0;
}

.tree li:first-child::after {
  border-radius: 5px 0 0 0;
}

.tree ul ul::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 2px solid var(--primary-color);
  width: 0;
  height: 20px;
}
</style>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import TreeNode from '@/Components/TreeNode.vue';
import MenuLateral from '@/Components/MenuLateral.vue';
import { usePage } from '@inertiajs/vue3';

// Referências de dados
const showMobileMenu = ref(false);
const showModal = ref(false);
const nodes = ref([]);
const service = ref({});
const form = ref({
  id: null,
  name: '',
  origin: '',
  type: '',
  smaller: 0,
  nato: '',
  il: '',
  matrimonio: ''
});
const genealogy = ref([]);

// Configurações para o PDF
const pdfSettings = ref({
  fontSize: 12,
  boxWidth: 200
});

// Pega o ID do serviço da página
const page = usePage();
const serviceId = page.props.id;

// Computed properties para estatísticas
const countAntepassados = computed(() => {
  return genealogy.value.filter(member => member.type === 1).length;
});

const countRequerentes = computed(() => {
  return genealogy.value.filter(member => member.type === 2).length;
});

// Funções para abrir modais
const openCreateModal = () => {
  resetForm();
  showModal.value = true;
};

const openEditModal = (node) => {
  form.value = { ...node };
  showModal.value = true;
};

// Carrega a árvore genealógica
async function loadGenealogyTree() {
  try {
    const { data } = await axios.get(`http://127.0.0.1:8000/api/genealogy/tree/${serviceId}`);
    service.value = data.service;
    genealogy.value = data.genealogy;
    nodes.value = organizeTree(data.genealogy);
  } catch (error) {
    console.error('Erro ao carregar genealogia:', error);
  }
}

// Organiza a árvore genealógica
function organizeTree(members) {
  const nameToNode = new Map();

  members.forEach(member => {
    nameToNode.set(member.name.trim(), { ...member, children: [] });
  });

  members.forEach(member => {
    const originName = member.origin?.trim();
    if (originName && nameToNode.has(originName)) {
      const parent = nameToNode.get(originName);
      const child = nameToNode.get(member.name.trim());
      parent.children.push(child);
    }
  });

  return members
    .filter(member => {
      const originName = member.origin?.trim();
      return !originName || !nameToNode.has(originName);
    })
    .map(member => nameToNode.get(member.name.trim()));
}

// Submete novo membro
async function submitForm() {
  try {
    const payload = { ...form.value, service: serviceId };

    if (form.value.id) {
      // Atualização
      await axios.put(`http://127.0.0.1:8000/api/genealogy/${form.value.id}`, payload);
      alert('Membro atualizado com sucesso!');
    } else {
      // Criação
      await axios.post('http://127.0.0.1:8000/api/genealogy', payload);
      alert('Membro cadastrado com sucesso!');
    }

    resetForm();
    closeModal();
    await loadGenealogyTree();
  } catch (error) {
    console.error('Erro ao salvar:', error);
    alert('Erro ao salvar o membro.');
  }
}

// Fecha o modal
function closeModal() {
  showModal.value = false;
  resetForm();
}

// Reseta o formulário
function resetForm() {
  form.value = {
    id: null,
    name: '',
    origin: '',
    type: '',
    smaller: 0,
    nato: '',
    il: '',
    matrimonio: ''
  };
}

// Deleta o membro
async function deleteMember(node) {
  if (!confirm('Tem certeza que deseja excluir este membro da árvore genealógica?')) {
    return;
  }
  
  try {
    await axios.delete(`http://127.0.0.1:8000/api/genealogy/${node.id}`);
    alert('Membro deletado com sucesso!');
    await loadGenealogyTree();
  } catch (error) {
    console.error('Erro ao deletar membro:', error);
    alert('Erro ao deletar o membro.');
  }
}

// Carrega a árvore ao montar o componente
onMounted(() => {
  loadGenealogyTree();
});
</script>