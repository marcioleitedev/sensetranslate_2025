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
              <i class="bi bi-file-earmark-text"></i>
              Gerenciar Orçamentos
            </h1>
            <p class="page-subtitle">Controle e gestão de propostas comerciais</p>
          </div>
          <div class="header-actions">
            <button class="btn-add" @click="showCreateModal = true">
              <i class="bi bi-file-earmark-plus"></i>
              Novo Orçamento
            </button>
          </div>
        </div>
      </div>

      <!-- Alert Messages -->
      <div v-if="flashMessage" class="alert-message" :class="flashType">
        <i class="bi" :class="getAlertIcon(flashType)"></i>
        {{ flashMessage }}
      </div>

      <!-- Controles e Filtros -->
      <div class="controls-section">
        <div class="search-box">
          <div class="search-input-group">
            <i class="bi bi-search search-icon"></i>
            <input
              type="text"
              v-model="searchTerm"
              class="search-input"
              placeholder="Buscar por nome, email, telefone..."
            />
            <button v-if="searchTerm" @click="searchTerm = ''" class="clear-search">
              <i class="bi bi-x-circle"></i>
            </button>
          </div>
        </div>
        <div class="stats-summary">
          <div class="stat-item">
            <strong>{{ budgets.total || 0 }}</strong>
            <span>Total</span>
          </div>
        </div>
      </div>

      <!-- Grid de Orçamentos -->
      <div class="budgets-grid">
        <div v-if="budgets.data && budgets.data.length > 0" class="budgets-container">
          <div v-for="budget in budgets.data" :key="budget.id" class="budget-card">
            <div class="budget-header">
              <div class="budget-info">
                <h4 class="budget-name">{{ budget.name }}</h4>
                <p class="budget-email">{{ budget.email }}</p>
                <p class="budget-phone">{{ budget.phone }}</p>
              </div>
              <div class="budget-price">
                <span class="price-label">Valor</span>
                <span class="price-value">R$ {{ formatPrice(budget.price) }}</span>
              </div>
            </div>
            <div class="budget-status">
              <span class="status-badge" :class="getStatusClass(budget.status)">
                <i class="bi" :class="getStatusIcon(budget.status)"></i>
                {{ getStatusName(budget.status) }}
              </span>
            </div>
            <div class="budget-actions">
              <button class="action-btn whatsapp" @click="sendPDFViaWhatsApp(budget)" title="Enviar WhatsApp">
                <i class="bi bi-whatsapp"></i>
              </button>
              <button class="action-btn edit" @click="openEditModal(budget)" title="Editar">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="action-btn delete" @click="removeBudget(budget.id)" title="Remover">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Estado Vazio -->
        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class="bi bi-file-earmark-text"></i>
          </div>
          <h3>Nenhum orçamento encontrado</h3>
          <p>{{ searchTerm ? 'Tente ajustar os filtros de busca' : 'Comece criando seu primeiro orçamento' }}</p>
          <button v-if="!searchTerm" class="btn-add" @click="showCreateModal = true">
            <i class="bi bi-file-earmark-plus"></i>
            Criar Orçamento
          </button>
        </div>
      </div>

      <!-- Paginação -->
      <div v-if="budgets.data && budgets.data.length > 0 && budgets.last_page > 1" class="pagination-section">
        <nav class="pagination-nav">
          <button 
            class="pagination-btn" 
            :disabled="!budgets.prev_page_url"
            @click="fetchBudgets(budgets.prev_page_url)"
          >
            <i class="bi bi-chevron-left"></i>
            Anterior
          </button>
          
          <div class="pagination-info">
            Página {{ budgets.current_page || 1 }} de {{ budgets.last_page || 1 }}
            <small style="display: block; font-size: 0.8em; color: #666;">
              ({{ budgets.total || 0 }} orçamentos no total)
            </small>
          </div>
          
          <button 
            class="pagination-btn" 
            :disabled="!budgets.next_page_url"
            @click="fetchBudgets(budgets.next_page_url)"
          >
            Próximo
            <i class="bi bi-chevron-right"></i>
          </button>
        </nav>
      </div>

      <!-- Modal de Criação -->
      <div v-if="showCreateModal" class="modal-overlay" @click="closeCreateModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2>
              <i class="bi bi-file-earmark-plus"></i>
              Criar Novo Orçamento
            </h2>
            <button class="modal-close" @click="closeCreateModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createBudget">
              <div class="form-group" v-for="(label, key) in fields" :key="key">
                <label class="form-label">
                  <i class="bi" :class="getFieldIcon(key)"></i>
                  {{ label }}
                </label>
                <input 
                  v-model="newBudget[key]" 
                  :type="getInputType(key)" 
                  class="form-input" 
                  :placeholder="`Digite ${label.toLowerCase()}`"
                  required 
                />
              </div>

              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-file-text"></i>
                  Conteúdo do Orçamento
                </label>
                <QuillEditorComponent
                  v-model:content="newBudget.content"
                  content-type="html"
                  :toolbar="[
                    ['bold', 'italic', 'underline'],
                    [{ header: 1 }, { header: 2 }],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link'],
                    ['clean']
                  ]"
                  style="min-height: 200px; background: white; border-radius: 8px;"
                />
              </div>

              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-flag"></i>
                  Status
                </label>
                <select v-model="newBudget.status" class="form-select">
                  <option value="1">Pendente</option>
                  <option value="2">Aprovado</option>
                  <option value="3">Rejeitado</option>
                </select>
              </div>

              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeCreateModal">
                  <i class="bi bi-x-circle"></i>
                  Cancelar
                </button>
                <button type="submit" class="btn-save">
                  <i class="bi bi-check-circle"></i>
                  Criar Orçamento
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal de Edição -->
      <div v-if="showEditModal" class="modal-overlay" @click="closeEditModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2>
              <i class="bi bi-pencil-square"></i>
              Editar Orçamento
            </h2>
            <button class="modal-close" @click="closeEditModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateBudget">
              <div class="form-group" v-for="(label, key) in fields" :key="key">
                <label class="form-label">
                  <i class="bi" :class="getFieldIcon(key)"></i>
                  {{ label }}
                </label>
                <input 
                  v-model="budgetToEdit[key]" 
                  :type="getInputType(key)" 
                  class="form-input" 
                  required 
                />
              </div>

              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-file-text"></i>
                  Conteúdo do Orçamento
                </label>
                <QuillEditorComponent
                  v-model:content="budgetToEdit.content"
                  content-type="html"
                  style="min-height: 200px; background: white; border-radius: 8px;"
                />
              </div>

              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-flag"></i>
                  Status
                </label>
                <select v-model="budgetToEdit.status" class="form-select">
                  <option value="1">Pendente</option>
                  <option value="2">Aprovado</option>
                  <option value="3">Rejeitado</option>
                </select>
              </div>

              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeEditModal">
                  <i class="bi bi-x-circle"></i>
                  Cancelar
                </button>
                <button type="submit" class="btn-save">
                  <i class="bi bi-check-circle"></i>
                  Atualizar Orçamento
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch , onMounted } from 'vue';
import axios from 'axios';
import debounce from 'lodash.debounce';
import MenuLateral from '@/Components/MenuLateral.vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { jwtDecode } from 'jwt-decode'

const QuillEditorComponent = QuillEditor;

const isAuthenticated = ref(false)
const user = ref({
  id: '',
  name: '',
  email: '',
  level: null,
  decodedToken: null,
})

onMounted(() => {
  const token = localStorage.getItem('token')

  if (!token) {
    throw new Error('Token não encontrado')
  }

  // Setar no axios
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
  console.log('Token configurado no axios:', axios.defaults.headers.common['Authorization'])

  // Decodificar token JWT
  try {
    const decoded = jwtDecode(token)

    // Guardar dados do usuário
    user.value = {
      id: decoded.sub,
      name: decoded.name,
      email: decoded.email,
      level: decoded.level,
      // decodedToken: decoded,
    }

    isAuthenticated.value = true

    console.log('Token decodificado:', user)
  } catch (error) {
    console.error('Erro ao decodificar token:', error)
  }

  document.addEventListener('click', handleClickOutside)
})

const showMobileMenu = ref(false);
const showCreateModal = ref(false);
const showEditModal = ref(false);

const newBudget = ref({ name: '', email: '', phone: '', price: '', status: 1, content: '' , user_id: ''});
const budgetToEdit = ref({ id: null, name: '', email: '', phone: '', price: '', status: 1, content: '' , user_id: '' });

const budgets = ref([]);
const paginationLinks = ref([]);
const flashMessage = ref('');
const flashType = ref('alert-info');
const searchTerm = ref('');

// Campos reutilizáveis
const fields = {
  name: 'Nome',
  email: 'Email',
  phone: 'Telefone',
  price: 'Preço'
};

// Funções utilitárias
const formatPrice = (price) => {
  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price);
};

const getFieldIcon = (key) => {
  const icons = {
    name: 'bi-person',
    email: 'bi-envelope',
    phone: 'bi-telephone',
    price: 'bi-currency-dollar'
  };
  return icons[key] || 'bi-info-circle';
};

const getInputType = (key) => {
  if (key === 'email') return 'email';
  if (key === 'price') return 'number';
  if (key === 'phone') return 'tel';
  return 'text';
};

const getAlertIcon = (type) => {
  if (type.includes('success')) return 'bi-check-circle';
  if (type.includes('danger')) return 'bi-exclamation-triangle';
  if (type.includes('warning')) return 'bi-exclamation-circle';
  return 'bi-info-circle';
};

const getStatusClass = (status) => {
  switch (status) {
    case 1: return 'status-pending';
    case 2: return 'status-approved';
    case 3: return 'status-rejected';
    default: return 'status-unknown';
  }
};

const getStatusIcon = (status) => {
  switch (status) {
    case 1: return 'bi-clock';
    case 2: return 'bi-check-circle';
    case 3: return 'bi-x-circle';
    default: return 'bi-question-circle';
  }
};

const getStatusName = (status) => {
  switch (status) {
    case 1: return 'Pendente';
    case 2: return 'Aprovado';
    case 3: return 'Rejeitado';
    default: return 'Desconhecido';
  }
};

// Funções de modal
const closeCreateModal = () => {
  showCreateModal.value = false;
  newBudget.value = { name: '', email: '', phone: '', price: '', status: 1, content: '', user_id: '' };
};

const closeEditModal = () => {
  showEditModal.value = false;
  budgetToEdit.value = { id: null, name: '', email: '', phone: '', price: '', status: 1, content: '', user_id: '' };
};

const getWhatsAppLink = (phone, content) => {
  const cleaned = phone.replace(/\D/g, '');
  const encodedContent = encodeURIComponent(content); // Codifica o conteúdo para ser usado na URL
  return `https://wa.me/55${cleaned}?text=${encodedContent}`;
};

const sendPDFViaWhatsApp = async (budget) => {
  try {
    // 1. Gerar PDF no backend com nome e content do orçamento
    const response = await axios.post('http://localhost:8000/api/generate-pdf', {
      name: budget.name,
      content: budget.content,
    });

    const pdfUrl = response.data.url;

    // 2. Montar link do WhatsApp com o link do PDF
    const phone = budget.phone.replace(/\D/g, '');
    const message = `Olá ${budget.name}, segue seu orçamento em PDF:\n${pdfUrl}`;
    const whatsappLink = `https://wa.me/55${phone}?text=${encodeURIComponent(message)}`;

    
    // 3. Abrir link do WhatsApp
    window.open(whatsappLink, '_blank');
  } catch (error) {
    console.error('Erro ao gerar PDF e enviar pelo WhatsApp:', error);
    showFlashMessage('Erro ao gerar PDF para WhatsApp.', 'alert-danger');
  }
};


const showFlashMessage = (message, type) => {
  flashMessage.value = message;
  flashType.value = type;
  setTimeout(() => (flashMessage.value = ''), 5000);
};

const fetchBudgets = async (url = null) => {
  try {
    const baseUrl = 'http://localhost:8000/api/budgets';
    const params = searchTerm.value ? { search: searchTerm.value } : {};
    const response = await axios.get(url || baseUrl, { params });
    budgets.value = response.data;
    paginationLinks.value = response.data.links;
  } catch (error) {
    console.error('Erro ao buscar orçamentos:', error);
  }
};

const debouncedFetch = debounce(fetchBudgets, 500);
watch(searchTerm, () => debouncedFetch());

const createBudget = async () => {
  try {

    newBudget.value.user_id = user.value.id; 
    console.log('Payload enviado:', newBudget.value);

    await axios.post('http://localhost:8000/api/budgets', newBudget.value);

    showFlashMessage('Orçamento criado com sucesso!', 'alert-success');
    showCreateModal.value = false;
    fetchBudgets();
  } catch (error) {
    console.error('Erro ao criar orçamento:', error);
    showFlashMessage('Erro ao criar orçamento', 'alert-danger');
  }
};


const openEditModal = (budget) => {
  // Verificar se os dados estão sendo passados corretamente
  console.log('Abrindo modal para editar o orçamento', budget);

  // Copiar os dados do orçamento para a variável de edição
  budgetToEdit.value = { ...budget };

  // Exibir o modal
  showEditModal.value = true;
};

const updateBudget = async () => {
  try {
    await axios.put(`http://localhost:8000/api/budgets/${budgetToEdit.value.id}`, budgetToEdit.value);
    showEditModal.value = false;
    showFlashMessage('Orçamento atualizado com sucesso.', 'alert-success');
    fetchBudgets();
  } catch (error) {
    showFlashMessage('Erro ao atualizar orçamento.', 'alert-danger');
    console.error(error);
  }
};

const removeBudget = async (budgetId) => {
  try {
    await axios.delete(`http://localhost:8000/api/budgets/${budgetId}`);
    showFlashMessage('Orçamento removido com sucesso.', 'alert-success');
    fetchBudgets();
  } catch (error) {
    showFlashMessage('Erro ao remover orçamento.', 'alert-danger');
    console.error(error);
  }
};

fetchBudgets();
</script>

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

/* Alert Messages */
.alert-message {
  margin-bottom: 2rem;
  padding: 1rem 1.5rem;
  border-radius: var(--border-radius);
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
  animation: slideDown 0.3s ease;
}

.alert-success {
  background: rgba(39, 174, 96, 0.1);
  color: var(--success-color);
  border: 1px solid rgba(39, 174, 96, 0.2);
}

.alert-danger {
  background: rgba(231, 76, 60, 0.1);
  color: var(--danger-color);
  border: 1px solid rgba(231, 76, 60, 0.2);
}

.alert-warning {
  background: rgba(243, 156, 18, 0.1);
  color: var(--warning-color);
  border: 1px solid rgba(243, 156, 18, 0.2);
}

.alert-info {
  background: rgba(52, 152, 219, 0.1);
  color: var(--info-color);
  border: 1px solid rgba(52, 152, 219, 0.2);
}

/* Controles */
.controls-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2rem;
  margin-bottom: 2rem;
  background: white;
  padding: 1.5rem 2rem;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
}

.search-box {
  flex: 1;
  max-width: 400px;
}

.search-input-group {
  position: relative;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 1rem;
  color: var(--text-light);
  z-index: 1;
}

.search-input {
  width: 100% !important;
  padding: 0.75rem 1rem 0.75rem 2.5rem !important;
  border: 2px solid #e9ecef !important;
  border-radius: 25px !important;
  font-size: 1rem !important;
  background: white !important;
  transition: all 0.3s ease !important;
  color: var(--text-dark) !important;
}

.search-input:focus {
  outline: none !important;
  border-color: var(--primary-color) !important;
  box-shadow: 0 0 0 3px rgba(226, 181, 96, 0.1) !important;
}

.clear-search {
  position: absolute !important;
  right: 0.5rem !important;
  background: none !important;
  border: none !important;
  color: var(--text-light) !important;
  cursor: pointer !important;
  padding: 0.25rem !important;
  border-radius: 50% !important;
  transition: all 0.3s ease !important;
}

.clear-search:hover {
  background: #f1f1f1 !important;
  color: var(--text-dark) !important;
}

.stats-summary {
  display: flex;
  gap: 1rem;
}

.stat-item {
  text-align: center;
  padding: 0.5rem 1rem;
  background: var(--primary-color);
  color: white;
  border-radius: 10px;
  font-weight: 600;
}

.stat-item strong {
  display: block;
  font-size: 1.2rem;
}

.stat-item span {
  font-size: 0.8rem;
  opacity: 0.9;
}

/* Grid de Orçamentos */
.budgets-grid {
  min-height: 400px;
}

.budgets-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
}

.budget-card {
  background: white;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  padding: 1.5rem;
  transition: all 0.3s ease;
  border: 1px solid #f1f1f1;
}

.budget-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-hover);
}

.budget-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.budget-info {
  flex: 1;
}

.budget-name {
  font-size: 1.1rem !important;
  font-weight: 600 !important;
  color: var(--text-dark) !important;
  margin: 0 0 0.25rem 0 !important;
}

.budget-email {
  font-size: 0.9rem !important;
  color: var(--text-light) !important;
  margin: 0 0 0.25rem 0 !important;
}

.budget-phone {
  font-size: 0.9rem !important;
  color: var(--text-light) !important;
  margin: 0 !important;
}

.budget-price {
  text-align: right;
}

.price-label {
  display: block;
  font-size: 0.8rem;
  color: var(--text-light);
  margin-bottom: 0.25rem;
}

.price-value {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--success-color);
}

.budget-status {
  margin-bottom: 1rem;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.status-pending {
  background: rgba(243, 156, 18, 0.1);
  color: var(--warning-color);
}

.status-approved {
  background: rgba(39, 174, 96, 0.1);
  color: var(--success-color);
}

.status-rejected {
  background: rgba(231, 76, 60, 0.1);
  color: var(--danger-color);
}

.budget-actions {
  display: flex;
  gap: 0.5rem;
  justify-content: flex-end;
}

.action-btn {
  width: 36px !important;
  height: 36px !important;
  border: none !important;
  border-radius: 8px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
  font-size: 1rem !important;
}

.action-btn.whatsapp {
  background: #25d366 !important;
  color: white !important;
}

.action-btn.whatsapp:hover {
  background: #128c7e !important;
  transform: translateY(-2px) !important;
}

.action-btn.edit {
  background: var(--primary-color) !important;
  color: white !important;
}

.action-btn.edit:hover {
  background: var(--secondary-color) !important;
  transform: translateY(-2px) !important;
}

.action-btn.delete {
  background: #dc3545 !important;
  color: white !important;
}

.action-btn.delete:hover {
  background: #c82333 !important;
  transform: translateY(-2px) !important;
}

/* Estado Vazio */
.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  background: white;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
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

/* Paginação */
.pagination-section {
  margin-top: 2rem;
  background: white;
  padding: 1rem 2rem;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
}

.pagination-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.pagination-btn {
  background: #6c757d !important;
  color: white !important;
  border: none !important;
  padding: 0.5rem 1rem !important;
  border-radius: 8px !important;
  font-weight: 600 !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
}

.pagination-btn:hover:not(:disabled) {
  background: #495057 !important;
  transform: translateY(-2px) !important;
}

.pagination-btn:disabled {
  background: #adb5bd !important;
  color: #6c757d !important;
  cursor: not-allowed !important;
  transform: none !important;
}

.pagination-info {
  color: var(--text-dark) !important;
  font-weight: 500 !important;
  font-size: 1rem !important;
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
  max-width: 600px !important;
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

.form-group {
  margin-bottom: 1.5rem;
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
    flex-direction: column;
    gap: 1rem;
  }
  
  .budgets-container {
    grid-template-columns: 1fr;
  }
  
  .pagination-nav {
    flex-direction: column;
    gap: 1rem;
  }
}

@media (max-width: 768px) {
  .page-title {
    font-size: 1.5rem !important;
  }
  
  .budget-card {
    padding: 1rem;
  }
  
  .modal-content {
    width: 95% !important;
    margin: 1rem !important;
  }
  
  .modal-header,
  .modal-body {
    padding: 1rem;
  }
}

/* Animações */
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
