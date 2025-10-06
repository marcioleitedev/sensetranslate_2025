<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  
  <div class="dashboard-wrapper">
    <!-- Botão toggle mobile -->
    <button class="btn btn-primary d-md-none toggle-btn" @click="showMobileMenu = !showMobileMenu">
      <i class="bi bi-list"></i>
    </button>

    <!-- Menu Component -->
    <MenuLateral
      :showMobileMenu="showMobileMenu"
      @update:showMobileMenu="showMobileMenu = $event"
    />

    <!-- Conteúdo Principal -->
    <main class="dashboard-content">
      
      <!-- Header da Página -->
      <div class="page-header">
        <div class="header-content">
          <div class="header-info">
            <h1 class="page-title">
              <i class="bi bi-people-fill"></i>
              Gerenciar Usuários
            </h1>
            <p class="page-subtitle">Controle de acesso e permissões do sistema</p>
          </div>
          <div class="header-actions">
            <button class="btn-add" @click="openCreateModal">
              <i class="bi bi-person-plus"></i>
              Novo Usuário
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
              class="search-input"
              placeholder="Buscar por nome ou email..."
              v-model="searchQuery"
            />
            <button v-if="searchQuery" class="clear-search" @click="searchQuery = ''">
              <i class="bi bi-x"></i>
            </button>
          </div>
        </div>
        
        <div class="stats-summary">
          <div class="stat-item">
            <span class="stat-number">{{ users.total || 0 }}</span>
            <span class="stat-label">Total</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">{{ users.data?.length || 0 }}</span>
            <span class="stat-label">Exibindo</span>
          </div>
        </div>
      </div>

      <!-- Lista de Usuários -->
      <div class="users-section">
        <div class="users-grid" v-if="users.data && users.data.length > 0">
          <div v-for="user in users.data" :key="user.id" class="user-card">
            <div class="user-avatar">
              <i class="bi bi-person-circle"></i>
            </div>
            <div class="user-info">
              <h4 class="user-name">{{ user.name }}</h4>
              <p class="user-email">{{ user.email }}</p>
              <span class="user-level" :class="getLevelClass(user.level)">
                <i class="bi" :class="getLevelIcon(user.level)"></i>
                {{ getLevelName(user.level) }}
              </span>
            </div>
            <div class="user-actions">
              <button class="action-btn edit" @click="openEditModal(user)" title="Editar">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="action-btn delete" @click="confirmDelete(user)" title="Remover">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Estado Vazio -->
        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class="bi bi-people"></i>
          </div>
          <h3>Nenhum usuário encontrado</h3>
          <p>{{ searchQuery ? 'Tente ajustar os filtros de busca' : 'Comece adicionando seu primeiro usuário' }}</p>
          <button v-if="!searchQuery" class="btn-add" @click="openCreateModal">
            <i class="bi bi-person-plus"></i>
            Adicionar Usuário
          </button>
        </div>
      </div>

      <!-- Paginação -->
      <div v-if="users.data && users.data.length > 0 && users.last_page > 1" class="pagination-section">
        <nav class="pagination-nav">
          <button 
            class="pagination-btn" 
            :disabled="!users.prev_page_url"
            @click="fetchUsers(users.prev_page_url)"
          >
            <i class="bi bi-chevron-left"></i>
            Anterior
          </button>
          
          <div class="pagination-info">
            Página {{ users.current_page || 1 }} de {{ users.last_page || 1 }}
            <small style="display: block; font-size: 0.8em; color: #666;">
              ({{ users.total || 0 }} usuários no total)
            </small>
          </div>
          
          <button 
            class="pagination-btn" 
            :disabled="!users.next_page_url"
            @click="fetchUsers(users.next_page_url)"
          >
            Próximo
            <i class="bi bi-chevron-right"></i>
          </button>
        </nav>
      </div>

      <!-- Modal de Cadastro -->
      <div v-if="showCreateModal" class="modal-overlay" @click="closeCreateModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2>
              <i class="bi bi-person-plus"></i>
              Novo Usuário
            </h2>
            <button class="modal-close" @click="closeCreateModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createUser">
              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-person"></i>
                  Nome Completo
                </label>
                <input 
                  type="text" 
                  class="form-input" 
                  v-model="newUser.name" 
                  placeholder="Digite o nome completo"
                  required 
                />
              </div>
              
              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-envelope"></i>
                  E-mail
                </label>
                <input 
                  type="email" 
                  class="form-input" 
                  v-model="newUser.email" 
                  placeholder="Digite o e-mail"
                  required 
                />
              </div>
              
              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-shield-check"></i>
                  Nível de Acesso
                </label>
                <select class="form-select" v-model="newUser.level" required>
                  <option value="1">Cliente</option>
                  <option value="2">Funcionário</option>
                  <option value="3">Administrador</option>
                </select>
              </div>
              
              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeCreateModal">
                  Cancelar
                </button>
                <button type="submit" class="btn-save">
                  <i class="bi bi-check"></i>
                  Cadastrar
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
              <i class="bi bi-pencil"></i>
              Editar Usuário
            </h2>
            <button class="modal-close" @click="closeEditModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateUser">
              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-person"></i>
                  Nome Completo
                </label>
                <input 
                  type="text" 
                  class="form-input" 
                  v-model="userToEdit.name" 
                  required 
                />
              </div>
              
              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-envelope"></i>
                  E-mail
                </label>
                <input 
                  type="email" 
                  class="form-input" 
                  v-model="userToEdit.email" 
                  required 
                />
              </div>
              
              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-shield-check"></i>
                  Nível de Acesso
                </label>
                <select class="form-select" v-model="userToEdit.level" required>
                  <option value="1">Cliente</option>
                  <option value="2">Funcionário</option>
                  <option value="3">Administrador</option>
                </select>
              </div>
              
              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeEditModal">
                  Cancelar
                </button>
                <button type="submit" class="btn-save">
                  <i class="bi bi-check"></i>
                  Salvar Alterações
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal de Confirmação de Exclusão -->
      <div v-if="showDeleteModal" class="modal-overlay" @click="closeDeleteModal">
        <div class="modal-content delete-modal" @click.stop>
          <div class="modal-header">
            <h2>
              <i class="bi bi-exclamation-triangle"></i>
              Confirmar Exclusão
            </h2>
            <button class="modal-close" @click="closeDeleteModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <p>Tem certeza que deseja remover o usuário <strong>{{ userToDelete?.name }}</strong>?</p>
            <p class="warning-text">Esta ação não pode ser desfeita.</p>
            
            <div class="modal-actions">
              <button type="button" class="btn-cancel" @click="closeDeleteModal">
                Cancelar
              </button>
              <button class="btn-delete" @click="removeUser(userToDelete.id)">
                <i class="bi bi-trash"></i>
                Sim, Remover
              </button>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import debounce from 'lodash.debounce';
import MenuLateral from '@/Components/MenuLateral.vue';

const showMobileMenu = ref(false);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);

const newUser = ref({ name: '', email: '', level: 1 });
const userToEdit = ref({ id: null, name: '', email: '', level: 1 });
const userToDelete = ref(null);

const users = ref([]);
const paginationLinks = ref([]);

const flashMessage = ref('');
const flashType = ref('alert-info');
const searchQuery = ref('');

const getLevelName = (level) => {
  switch (level) {
    case 1: return 'Cliente';
    case 2: return 'Funcionário';
    case 3: return 'Administrador';
    default: return 'Desconhecido';
  }
};

const getLevelClass = (level) => {
  switch (level) {
    case 1: return 'level-client';
    case 2: return 'level-employee';
    case 3: return 'level-admin';
    default: return 'level-unknown';
  }
};

const getLevelIcon = (level) => {
  switch (level) {
    case 1: return 'bi-person';
    case 2: return 'bi-briefcase';
    case 3: return 'bi-shield-check';
    default: return 'bi-question-circle';
  }
};

const getAlertIcon = (type) => {
  switch (type) {
    case 'alert-success': return 'bi-check-circle-fill';
    case 'alert-danger': return 'bi-exclamation-triangle-fill';
    case 'alert-warning': return 'bi-exclamation-triangle-fill';
    default: return 'bi-info-circle-fill';
  }
};

const showFlashMessage = (message, type) => {
  flashMessage.value = message;
  flashType.value = type;
  setTimeout(() => (flashMessage.value = ''), 5000);
};

const fetchUsers = async (url = null) => {
  try {
    let finalUrl = url || 'http://localhost:8000/api/usuarios';
    const params = {};

    if (searchQuery.value) {
      params.search = searchQuery.value;
    }

    const response = await axios.get(finalUrl, { params });
    
    // Garantir que os dados de paginação existam
    users.value = {
      data: response.data.data || [],
      current_page: response.data.current_page || 1,
      last_page: response.data.last_page || 1,
      total: response.data.total || 0,
      prev_page_url: response.data.prev_page_url || null,
      next_page_url: response.data.next_page_url || null,
      links: response.data.links || []
    };
    
    paginationLinks.value = response.data.links || [];
    
  } catch (error) {
    console.error('Erro ao buscar usuários:', error);
    showFlashMessage('Erro ao carregar usuários.', 'alert-danger');
  }
};

// Busca automática com debounce
const debouncedFetchUsers = debounce(fetchUsers, 500);
watch(searchQuery, () => {
  debouncedFetchUsers();
});

const createUser = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/usuarios', newUser.value);
    showFlashMessage(response.data.message || 'Usuário cadastrado com sucesso!', 'alert-success');
    closeCreateModal();
    fetchUsers();
  } catch (error) {
    showFlashMessage('Erro ao cadastrar usuário.', 'alert-danger');
    console.error(error);
  }
};

const openEditModal = (user) => {
  userToEdit.value = { ...user };
  showEditModal.value = true;
};

const updateUser = async () => {
  try {
    const response = await axios.put(`http://localhost:8000/api/usuarios/${userToEdit.value.id}`, userToEdit.value);
    showFlashMessage(response.data.message || 'Usuário atualizado com sucesso!', 'alert-success');
    closeEditModal();
    fetchUsers();
  } catch (error) {
    showFlashMessage('Erro ao atualizar usuário.', 'alert-danger');
    console.error(error);
  }
};

const confirmDelete = (user) => {
  userToDelete.value = user;
  showDeleteModal.value = true;
};

const removeUser = async (userId) => {
  try {
    await axios.delete(`http://localhost:8000/api/usuarios/${userId}`);
    showFlashMessage('Usuário removido com sucesso.', 'alert-success');
    closeDeleteModal();
    fetchUsers();
  } catch (error) {
    showFlashMessage('Erro ao remover usuário.', 'alert-danger');
    console.error(error);
  }
};

const closeCreateModal = () => {
  showCreateModal.value = false;
  newUser.value = { name: '', email: '', level: 1 };
};

const openCreateModal = () => {
  console.log('Abrindo modal de cadastro...');
  showCreateModal.value = true;
  console.log('showCreateModal:', showCreateModal.value);
};

const closeEditModal = () => {
  showEditModal.value = false;
  userToEdit.value = { id: null, name: '', email: '', level: 1 };
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  userToDelete.value = null;
};

onMounted(fetchUsers);
</script>

<style scoped>
/* Variáveis */
:root {
  --primary-color: #e2b560;
  --secondary-color: #2c3e50;
  --accent-color: #3498db;
  --text-dark: #333;
  --text-light: #666;
  --bg-light: #f8f9fa;
  --bg-white: #ffffff;
  --shadow: 0 4px 15px rgba(0,0,0,0.1);
  --shadow-hover: 0 8px 25px rgba(0,0,0,0.15);
  --success-color: #27ae60;
  --warning-color: #f39c12;
  --danger-color: #e74c3c;
  --info-color: #3498db;
  --border-radius: 15px;
}

/* Layout Principal */
.dashboard-wrapper {
  display: flex;
  min-height: 100vh;
  background: var(--bg-light);
}

.dashboard-content {
  flex: 1;
  margin-left: 220px;
  padding: 2rem;
  transition: margin-left 0.3s ease;
  min-height: 100vh;
}

/* Header da Página */
.page-header {
  background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
  border-radius: var(--border-radius);
  padding: 2rem;
  margin-bottom: 2rem;
  color: white;
  box-shadow: var(--shadow);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
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
  border: 1px solid rgba(39, 174, 96, 0.3);
}

.alert-danger {
  background: rgba(231, 76, 60, 0.1);
  color: var(--danger-color);
  border: 1px solid rgba(231, 76, 60, 0.3);
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Controles e Filtros */
.controls-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  gap: 1rem;
  flex-wrap: wrap;
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
  background: white;
  border-radius: 10px;
  box-shadow: var(--shadow);
}

.stat-number {
  display: block;
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--primary-color);
}

.stat-label {
  font-size: 0.8rem;
  color: var(--text-light);
  text-transform: uppercase;
}

/* Lista de Usuários */
.users-section {
  margin-bottom: 2rem;
}

.users-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.5rem;
}

.user-card {
  background: white;
  border-radius: var(--border-radius);
  padding: 1.5rem;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.user-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-hover);
}

.user-avatar {
  font-size: 3rem;
  color: var(--primary-color);
  flex-shrink: 0;
}

.user-info {
  flex: 1;
}

.user-name {
  font-size: 1.1rem !important;
  font-weight: 600 !important;
  color: var(--text-dark) !important;
  margin: 0 0 0.25rem 0 !important;
}

.user-email {
  font-size: 0.9rem !important;
  color: var(--text-light) !important;
  margin: 0 0 0.5rem 0 !important;
}

.user-level {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.level-client {
  background: rgba(52, 152, 219, 0.1);
  color: var(--info-color);
}

.level-employee {
  background: rgba(243, 156, 18, 0.1);
  color: var(--warning-color);
}

.level-admin {
  background: rgba(39, 174, 96, 0.1);
  color: var(--success-color);
}

.user-actions {
  display: flex;
  gap: 0.5rem;
  flex-shrink: 0;
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
}

.pagination-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: white;
  padding: 1rem 2rem;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
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
  max-width: 500px !important;
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

.btn-delete {
  background: var(--danger-color) !important;
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

.btn-delete:hover {
  background: #c0392b;
  transform: translateY(-2px);
}

.delete-modal {
  max-width: 400px;
}

.warning-text {
  color: var(--warning-color);
  font-weight: 500;
  font-style: italic;
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
    text-align: center;
  }
  
  .page-title {
    font-size: 1.8rem;
  }
  
  .controls-section {
    flex-direction: column;
    align-items: stretch;
  }
  
  .search-box {
    max-width: none;
  }
  
  .users-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .dashboard-content {
    padding: 1rem;
  }
  
  .page-header {
    padding: 1.5rem;
  }
  
  .page-title {
    font-size: 1.5rem;
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .user-card {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }
  
  .user-actions {
    justify-content: center;
  }
  
  .stats-summary {
    justify-content: center;
  }
  
  .pagination-nav {
    flex-direction: column;
    gap: 1rem;
  }
}

@media (max-width: 576px) {
  .dashboard-content {
    padding: 0.75rem;
  }
  
  .page-header {
    padding: 1rem;
  }
  
  .modal-content {
    width: 95%;
  }
  
  .modal-header,
  .modal-body {
    padding: 1.5rem;
  }
  
  .modal-actions {
    flex-direction: column;
  }
  
  .user-card {
    padding: 1rem;
  }
}
</style>
