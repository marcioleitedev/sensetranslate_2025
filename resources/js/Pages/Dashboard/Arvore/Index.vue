<template>
  <!-- Link para o Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <div class="d-flex">
    <!-- Botão toggle mobile -->
    <button class="btn btn-primary d-md-none toggle-btn" @click="showMobileMenu = !showMobileMenu">
      <i class="bi bi-list"></i>
    </button>

    <!-- Menu lateral -->
    <MenuLateral :showMobileMenu="showMobileMenu" @update:showMobileMenu="showMobileMenu = $event" />

    <!-- Conteúdo principal -->
    <main class="conteudo flex-grow-1 p-4">
      <div>
        <h2>Genealogy Tree</h2>
        <h5>Serviço de {{ service.name }}</h5>

        <!-- Botão para abrir o modal -->
        <button class="btn btn-success mb-4" @click="showModal = true">
          Cadastrar Membro
        </button>

        <!-- Modal -->
        <div class="modal fade" :class="{ show: showModal }" tabindex="-1" style="display: block;" v-if="showModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Cadastrar Membro</h5>
                <button type="button" class="btn-close" @click="closeModal"></button>
              </div>
              <div class="modal-body">
                <form class="form" @submit.prevent="submitForm">
                  <!-- Campos do Formulário -->
                  <div class="form-group mb-3">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" v-model="form.name" />
                  </div>

                  <div class="form-group mb-3">
                    <label>Tipo</label>
                    <select name="type" class="form-control" v-model="form.type">
                      <option value="1">Antenato</option>
                      <option value="2">Requerente</option>
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label>Origem</label>
                    <select class="form-control" name="origin" v-model="form.origin">
                      <option value="">Selecione a Origem</option>
                      <option v-for="member in genealogy" :key="member.id" :value="member.name">
                        {{ member.name }}
                      </option>
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label>Menor de Idade</label>
                    <select name="smaller" class="form-control" v-model="form.smaller">
                      <option value="0">Não</option>
                      <option value="1">Sim</option>
                    </select>
                  </div>

                  <h5 class="mt-4">Opcional</h5>

                  <div class="form-group mb-3">
                    <label>Nato in</label>
                    <input type="text" class="form-control" name="nato" v-model="form.nato" />
                  </div>

                  <div class="form-group mb-3">
                    <label>Il</label>
                    <input type="date" class="form-control" name="il" v-model="form.il" />
                  </div>

                  <div class="form-group mb-3">
                    <label>Dal Matrimonio com</label>
                    <input type="text" class="form-control" name="matrimonio" v-model="form.matrimonio" />
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Fundo do modal (escurecido) -->
        <div v-if="showModal" class="modal-backdrop fade show"></div>

        <!-- Árvore Genealógica -->
        <div class="tree mt-4">
          <ul>
            <TreeNode v-for="node in nodes" :key="node.id" :node="node" @edit="openEditModal" @delete="deleteMember" />
          </ul>
        </div>


        <!-- Formulário para ajustar PDF -->
        <div class="form-group col-12">
       
          <input
            type="number"
            id="fontSize"
            class="form-control"
            v-model="pdfSettings.fontSize"
            min="8"
            max="24"
            placeholder="Tamanho da Fonte (8-24)"
          />
        </div>

        <div class="form-group col-12">
       
          <input
            type="number"
            id="boxWidth"
            class="form-control"
            v-model="pdfSettings.boxWidth"
            min="100"
            max="500"
            placeholder="Largura do Box (100-500)"
          />
        </div>

        <!-- Visualizar PDF -->
        <div class="col-12 d-flex flex-column align-items-center mt-1">
          <div class="mt-auto">
            <a
              :href="`/dashboard/pdf/${serviceId}?fontSize=${pdfSettings.fontSize}&boxWidth=${pdfSettings.boxWidth}`"
              class="btn btn-success mb-4"
              target="_blank"
              rel="noopener"
            >
              Visualizar PDF
            </a>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.form-group {
  display: block; /* Garante que a div seja exibida como um bloco */
  margin-top: 20px; /* Adiciona espaçamento entre as divs */
}
.conteudo {
  margin-left: 220px;
  transition: margin-left 0.3s ease;
  background: #ffffff;
}

@media (max-width: 700px) {
  .conteudo {
    margin-left: 0 !important;
  }

  .toggle-btn {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1100;
  }
}

/* Estilos para modal */
.modal {
  background: rgba(0, 0, 0, 0.5);
  overflow-y: auto;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #000;
  opacity: 0.5;
  z-index: 1050;
}

.modal-dialog {
  margin-top: 10%;
}
</style>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import TreeNode from '@/Components/TreeNode.vue';
import MenuLateral from '@/components/MenuLateral.vue';
import { usePage } from '@inertiajs/vue3';

// Referências de dados
const showMobileMenu = ref(false);
const showModal = ref(false);
const editModal = ref(false); // Modal de edição
const nodes = ref([]);
const service = ref({});
const form = ref({
  name: '',
  origin: '',
  type: 1,
  smaller: 0,
  nato: '',
  il: '',
  matrimonio: ''
});
const genealogy = ref([]);

// Configurações para o PDF
const pdfSettings = ref({
  fontSize: null, // Tamanho de fonte padrão
  boxWidth: null // Largura do box padrão
});

// Pega o ID do serviço da página
const page = usePage();
const serviceId = page.props.id;

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
  editModal.value = false; // Fecha o modal de edição também
}

// Reseta o formulário
function resetForm() {
  form.value = {
    id: null,
    name: '',
    origin: '',
    type: 1,
    smaller: 0,
    nato: '',
    il: '',
    matrimonio: ''
  };
}

// Abre o modal de edição
function openEditModal(node) {
  form.value = { ...node }; // Preenche o formulário com os dados do nó selecionado
  editModal.value = true; // Abre o modal de edição
  showModal.value = true; // Abre o modal de edição
}

// Deleta o membro
async function deleteMember(node) {
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