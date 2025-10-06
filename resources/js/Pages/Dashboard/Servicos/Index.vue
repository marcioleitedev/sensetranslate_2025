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
              <i class="bi bi-gear-fill"></i>
              Gerenciar Serviços
            </h1>
            <p class="page-subtitle">Controle e gestão de serviços e projetos</p>
          </div>
          <div class="header-actions">
            <button class="btn-add" @click="openCreateModal">
              <i class="bi bi-plus-circle"></i>
              Novo Serviço
            </button>
          </div>
        </div>
      </div>

      <!-- Alert Messages -->
      <div v-if="flashMessage" class="alert-message" :class="flashClass">
        <i class="bi" :class="getAlertIcon(flashClass)"></i>
        {{ flashMessage }}
      </div>

      <!-- Controles e Filtros -->
      <div class="controls-section">
        <div class="search-box">
          <div class="search-input-group">
            <i class="bi bi-search search-icon"></i>
            <input
              type="text"
              v-model="search"
              @input="onSearchInput"
              class="search-input"
              placeholder="Buscar serviços..."
            />
            <button v-if="search" @click="clearSearch" class="clear-search">
              <i class="bi bi-x-circle"></i>
            </button>
          </div>
        </div>
        <div class="stats-summary">
          <div class="stat-item">
            <strong>{{ services.meta?.total || 0 }}</strong>
            <span>Total</span>
          </div>
        </div>
      </div>

      <!-- Grid de Serviços -->
      <div class="services-grid">
        <div v-if="services.data && services.data.length > 0" class="services-container">
          <div v-for="service in services.data" :key="service.id" class="service-card">
            <div class="service-header">
              <div class="service-info">
                <h4 class="service-name">{{ service.name }}</h4>
                <p class="service-period">
                  <i class="bi bi-calendar-range"></i>
                  {{ formatDate(service.start) }} - {{ formatDate(service.end) }}
                </p>
                <p class="service-payment">
                  <i class="bi bi-credit-card"></i>
                  {{ service.method_payment }}
                </p>
              </div>
              <div class="service-price">
                <span class="price-label">Valor</span>
                <span class="price-value">R$ {{ formatPrice(service.price) }}</span>
              </div>
            </div>
            <div class="service-status">
              <span class="status-badge" :class="getStatusClass(service.status)">
                <i class="bi" :class="getStatusIcon(service.status)"></i>
                {{ statusMap[service.status] }}
              </span>
            </div>
            <div v-if="service.obs" class="service-obs">
              <small><i class="bi bi-info-circle"></i> {{ service.obs }}</small>
            </div>
            <div class="service-actions">
              <a :href="`/dashboard/arvore/${service.id}`" class="action-btn tree" title="Ver Árvore">
                <i class="bi bi-diagram-3"></i>
              </a>
              <button class="action-btn schedule" @click="openScheduleModal(service)" title="Agendamento">
                <i class="bi bi-calendar-plus"></i>
              </button>
              <button class="action-btn edit" @click="openEditModal(service)" title="Editar">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="action-btn delete" @click="removeService(service.id)" title="Remover">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Estado Vazio -->
        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class="bi bi-gear"></i>
          </div>
          <h3>Nenhum serviço encontrado</h3>
          <p>{{ search ? 'Tente ajustar os filtros de busca' : 'Comece criando seu primeiro serviço' }}</p>
          <button v-if="!search" class="btn-add" @click="openCreateModal">
            <i class="bi bi-plus-circle"></i>
            Criar Serviço
          </button>
        </div>
      </div>

      <!-- Paginação -->
      <div v-if="services.data && services.data.length > 0 && services.meta && services.meta.last_page > 1" class="pagination-section">
        <nav class="pagination-nav">
          <button 
            class="pagination-btn" 
            :disabled="!services.links?.prev"
            @click="fetchServices(services.meta.current_page - 1)"
          >
            <i class="bi bi-chevron-left"></i>
            Anterior
          </button>
          
          <div class="pagination-info">
            Página {{ services.meta?.current_page || 1 }} de {{ services.meta?.last_page || 1 }}
            <small style="display: block; font-size: 0.8em; color: #666;">
              ({{ services.meta?.total || 0 }} serviços no total)
            </small>
          </div>
          
          <button 
            class="pagination-btn" 
            :disabled="!services.links?.next"
            @click="fetchServices(services.meta.current_page + 1)"
          >
            Próximo
            <i class="bi bi-chevron-right"></i>
          </button>
        </nav>
      </div>

      <!-- Modal de Criação/Edição -->
      <div v-if="showModal" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2>
              <i class="bi" :class="currentService.id ? 'bi-pencil-square' : 'bi-plus-circle'"></i>
              {{ modalTitle }}
            </h2>
            <button class="modal-close" @click="closeModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveService">
              <div class="form-group" v-for="field in formFields" :key="field.model">
                <label class="form-label">
                  <i class="bi" :class="getFieldIcon(field.model)"></i>
                  {{ field.label }}
                </label>

                <!-- Input -->
                <input
                  v-if="field.type === 'input'"
                  v-model="currentService[field.model]"
                  :type="field.inputType"
                  class="form-input"
                  :placeholder="`Digite ${field.label.toLowerCase()}`"
                  required
                />

                <!-- Textarea -->
                <textarea
                  v-else-if="field.type === 'textarea'"
                  v-model="currentService[field.model]"
                  :rows="field.rows"
                  class="form-input"
                  :placeholder="`Digite ${field.label.toLowerCase()}`"
                  style="resize: vertical; min-height: 80px;"
                ></textarea>

                <!-- Select -->
                <select
                  v-else-if="field.type === 'select'"
                  v-model="currentService[field.model]"
                  class="form-select"
                  required
                >
                  <option value="" disabled>Selecione {{ field.label.toLowerCase() }}</option>
                  <option v-for="option in field.options" :key="option.value" :value="option.value">
                    {{ option.text }}
                  </option>
                </select>

                <!-- Fallback -->
                <div v-else class="field-error">
                  <small class="text-muted">Tipo de campo "{{ field.type }}" não suportado.</small>
                </div>
              </div>

              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeModal">
                  <i class="bi bi-x-circle"></i>
                  Cancelar
                </button>
                <button type="submit" class="btn-save">
                  <i class="bi bi-check-circle"></i>
                  {{ modalButtonText }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal de Agendamento -->
      <div v-if="showScheduleModal" class="modal-overlay" @click="closeScheduleModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2>
              <i class="bi bi-calendar-plus"></i>
              Agendamento - {{ selectedService?.name }}
            </h2>
            <button class="modal-close" @click="closeScheduleModal">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="processSchedule">
              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-person"></i>
                  Nome do Cliente
                </label>
                <input
                  v-model="scheduleData.clientName"
                  type="text"
                  class="form-input"
                  placeholder="Digite o nome completo do cliente"
                  required
                />
              </div>

              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-envelope"></i>
                  Email do Cliente
                </label>
                <input
                  v-model="scheduleData.clientEmail"
                  type="email"
                  class="form-input"
                  placeholder="Digite o email do cliente"
                  required
                />
              </div>

              <div class="form-group">
                <label class="form-label">
                  <i class="bi bi-key"></i>
                  Senha de Acesso
                </label>
                <input
                  v-model="scheduleData.password"
                  type="password"
                  class="form-input"
                  placeholder="Digite a senha de acesso"
                  required
                />
              </div>

              <div class="schedule-info">
                <div class="info-item">
                  <i class="bi bi-info-circle"></i>
                  <span>Estes dados serão enviados para o sistema de agendamento Python</span>
                </div>
              </div>

              <!-- Barra de Progresso -->
              <div v-if="isProcessingSchedule" class="progress-info">
                <div class="progress-bar">
                  <div class="progress-fill" :style="{ width: scheduleProgress + '%' }"></div>
                </div>
                <span class="progress-text">{{ scheduleProgress }}% concluído</span>
              </div>

              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeScheduleModal">
                  <i class="bi bi-x-circle"></i>
                  Cancelar
                </button>
                <button type="submit" class="btn-schedule" :disabled="isProcessingSchedule">
                  <i class="bi" :class="isProcessingSchedule ? 'bi-arrow-repeat spin' : 'bi-send'"></i>
                  {{ isProcessingSchedule ? 'Processando...' : 'Enviar Agendamento' }}
                </button>
              </div>
            </form>

            <!-- Área de Resultado do Webhook -->
            <div v-if="scheduleResult" class="result-section">
              <div class="result-header">
                <h4><i class="bi bi-check-circle"></i> Resposta do Sistema</h4>
                <div class="result-actions">
                  <button class="action-btn" @click="copyScheduleResult">
                    <i class="bi bi-clipboard"></i>
                    Copiar
                  </button>
                </div>
              </div>
              
              <div class="result-content">
                <pre class="result-text">{{ scheduleResult }}</pre>
              </div>
              
              <div class="result-stats">
                <span class="stat">Processado em: {{ scheduleProcessingTime }}s</span>
                <span class="stat">Status: {{ scheduleResultStatus }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import debounce from 'lodash.debounce';
import MenuLateral from '@/Components/MenuLateral.vue';

const services = ref({});
const showModal = ref(false);
const modalTitle = ref('Criar Serviço');
const modalButtonText = ref('Salvar');
const search = ref('');
const showMobileMenu = ref(false);

// Variáveis para o modal de agendamento
const showScheduleModal = ref(false);
const selectedService = ref(null);
const isProcessingSchedule = ref(false);
const scheduleProgress = ref(0);
const scheduleResult = ref('');
const scheduleProcessingTime = ref(0);
const scheduleResultStatus = ref('');
const scheduleData = ref({
  clientName: '',
  clientEmail: '',
  password: ''
});
const currentService = ref({
  id: null,
  name: '',
  price: '',
  method_payment: '',
  status: 1,
  start: '',
  end: '',
  obs: ''
});

const flashMessage = ref('');
const flashClass = ref('');

const showFlashMessage = (message, cssClass = 'alert-success') => {
  flashMessage.value = message;
  flashClass.value = cssClass;
  setTimeout(() => {
    flashMessage.value = '';
  }, 4000);
};

// Campos dinâmicos do modal
const formFields = [
  { model: 'name', label: 'Nome', type: 'input', inputType: 'text' },
  { model: 'price', label: 'Preço', type: 'input', inputType: 'number' },
  { model: 'method_payment', label: 'Forma de Pagamento', type: 'input', inputType: 'text' },
  { 
    model: 'status', 
    label: 'Status', 
    type: 'select', 
    inputType: '', 
    options: [
      { value: 1, text: 'Criado' },
      { value: 2, text: 'Documentos Enviados' },
      { value: 3, text: 'Em Processo' },
      { value: 4, text: 'Finalizado' },
      { value: 5, text: 'Entregue' },
      { value: 6, text: 'Faturado' }
    ] 
  },
  { model: 'start', label: 'Data de Início', type: 'input', inputType: 'date' },
  { model: 'end', label: 'Data de Término', type: 'input', inputType: 'date' },

  { model: 'obs', label: 'Observações', type: 'textarea', rows: 3 }
];

const statusMap = {
  1: 'Criado',
  2: 'Documentos Enviados',
  3: 'Em Processo',
  4: 'Finalizado',
  5: 'Entregue',
  6: 'Faturado'
};

// Funções utilitárias
const formatPrice = (price) => {
  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price);
};

const getFieldIcon = (field) => {
  const icons = {
    name: 'bi-tag',
    price: 'bi-currency-dollar',
    method_payment: 'bi-credit-card',
    status: 'bi-flag',
    start: 'bi-calendar-event',
    end: 'bi-calendar-check',
    obs: 'bi-chat-text'
  };
  return icons[field] || 'bi-info-circle';
};

const getAlertIcon = (type) => {
  if (type.includes('success')) return 'bi-check-circle';
  if (type.includes('danger')) return 'bi-exclamation-triangle';
  if (type.includes('warning')) return 'bi-exclamation-circle';
  return 'bi-info-circle';
};

const getStatusClass = (status) => {
  switch (status) {
    case 1: return 'status-created';
    case 2: return 'status-documents';
    case 3: return 'status-process';
    case 4: return 'status-finished';
    case 5: return 'status-delivered';
    case 6: return 'status-billed';
    default: return 'status-unknown';
  }
};

const getStatusIcon = (status) => {
  switch (status) {
    case 1: return 'bi-plus-circle';
    case 2: return 'bi-file-earmark-text';
    case 3: return 'bi-gear';
    case 4: return 'bi-check-circle';
    case 5: return 'bi-truck';
    case 6: return 'bi-receipt';
    default: return 'bi-question-circle';
  }
};

const fetchServices = async (page = 1) => {
  try {
    const response = await axios.get('http://localhost:8000/api/services', {
      params: { page, search: search.value }
    });
    services.value = response.data;
  } catch (error) {
    console.error('Erro ao buscar serviços:', error);
  }
};

const onSearchInput = debounce(() => {
  fetchServices(1);
}, 500);

const clearSearch = () => {
  search.value = '';
  fetchServices(1);
};

const openCreateModal = () => {
  currentService.value = { id: null, name: '', price: '', method_payment: '', status: 1, start: '', end: '', contract: '', obs: '' };
  modalTitle.value = 'Criar Serviço';
  modalButtonText.value = 'Salvar';
  showModal.value = true;
};

const openEditModal = (service) => {
  console.log('Serviço selecionado para edição:', service); // Log para depuração
  currentService.value = { ...service }; // Preenche o formulário com os dados do serviço
  modalTitle.value = 'Editar Serviço';
  modalButtonText.value = 'Atualizar';
  showModal.value = true;
};

const saveService = async () => {
  try {
    if (currentService.value.id) {
      await axios.put(`http://localhost:8000/api/services/${currentService.value.id}`, currentService.value);
    } else {
      await axios.post('http://localhost:8000/api/services', currentService.value);
    }
    showModal.value = false;
    fetchServices();
  } catch (error) {
    console.error('Erro ao salvar serviço:', error);
  }
};

const removeService = async (id) => {
  if (!confirm('Tem certeza que deseja excluir este serviço?')) return;
  try {
    await axios.delete(`http://localhost:8000/api/services/${id}`);
    showFlashMessage('Serviço removido com sucesso.', 'alert-success');
    fetchServices();
  } catch (error) {
    console.error('Erro ao remover serviço:', error);
  }
};

const closeModal = () => {
  showModal.value = false;
};

// Funções do modal de agendamento
const openScheduleModal = (service) => {
  selectedService.value = service;
  scheduleData.value = {
    clientName: '',
    clientEmail: '',
    password: ''
  };
  showScheduleModal.value = true;
};

const closeScheduleModal = () => {
  showScheduleModal.value = false;
  selectedService.value = null;
  scheduleData.value = {
    clientName: '',
    clientEmail: '',
    password: ''
  };
  scheduleResult.value = '';
  scheduleProgress.value = 0;
  scheduleProcessingTime.value = 0;
  scheduleResultStatus.value = '';
};

const processSchedule = async () => {
  isProcessingSchedule.value = true;
  scheduleProgress.value = 0;
  const startTime = Date.now();
  
  try {
    // Simular progresso
    const progressInterval = setInterval(() => {
      if (scheduleProgress.value < 90) {
        scheduleProgress.value += Math.random() * 10;
      }
    }, 300);

    // Dados a serem enviados para o webhook
    const payload = {
      serviceId: selectedService.value.id,
      serviceName: selectedService.value.name,
      clientName: scheduleData.value.clientName,
      clientEmail: scheduleData.value.clientEmail,
      password: scheduleData.value.password,
      timestamp: new Date().toISOString()
    };

    console.log('Enviando dados do agendamento:', payload);
    
    // Enviar para o webhook
    const response = await axios.post('https://sense-n8n.lbbcpb.easypanel.host/webhook/agendamento', payload, {
      headers: {
        'Content-Type': 'application/json',
      }
    });

    clearInterval(progressInterval);
    scheduleProgress.value = 100;

    console.log('Resposta do webhook:', response.data);
    
    // Processar resposta e exibir resultado
    scheduleResult.value = typeof response.data === 'string' 
      ? response.data 
      : JSON.stringify(response.data, null, 2);
    
    scheduleProcessingTime.value = ((Date.now() - startTime) / 1000).toFixed(2);
    scheduleResultStatus.value = 'Sucesso';
    
    showFlashMessage('Agendamento processado com sucesso!', 'alert-success');
    
  } catch (error) {
    console.error('Erro ao processar agendamento:', error);
    
    // Exibir erro como resultado
    scheduleResult.value = `Erro ao processar agendamento:\n\n${error.response?.data?.message || error.message}\n\nStatus: ${error.response?.status || 'Desconhecido'}`;
    scheduleProcessingTime.value = ((Date.now() - startTime) / 1000).toFixed(2);
    scheduleResultStatus.value = 'Erro';
    
    showFlashMessage('Erro ao processar agendamento', 'alert-error');
  } finally {
    isProcessingSchedule.value = false;
  }
};

// Função para copiar o resultado do agendamento
const copyScheduleResult = async () => {
  try {
    await navigator.clipboard.writeText(scheduleResult.value);
    showFlashMessage('Resultado copiado para a área de transferência!', 'alert-success');
  } catch (error) {
    showFlashMessage('Erro ao copiar resultado', 'alert-error');
  }
};

const formatDate = (date) => {
  if (!date) return '';
  return new Date(date).toLocaleDateString('pt-BR');
};

onMounted(() => {
  fetchServices();
});
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

/* Grid de Serviços */
.services-grid {
  min-height: 400px;
}

.services-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
}

.service-card {
  background: white;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  padding: 1.5rem;
  transition: all 0.3s ease;
  border: 1px solid #f1f1f1;
}

.service-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-hover);
}

.service-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.service-info {
  flex: 1;
}

.service-name {
  font-size: 1.1rem !important;
  font-weight: 600 !important;
  color: var(--text-dark) !important;
  margin: 0 0 0.5rem 0 !important;
}

.service-period,
.service-payment {
  font-size: 0.9rem !important;
  color: var(--text-light) !important;
  margin: 0 0 0.25rem 0 !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
}

.service-price {
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

.service-status {
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

.status-created {
  background: rgba(52, 152, 219, 0.1);
  color: var(--info-color);
}

.status-documents {
  background: rgba(243, 156, 18, 0.1);
  color: var(--warning-color);
}

.status-process {
  background: rgba(155, 89, 182, 0.1);
  color: #9b59b6;
}

.status-finished {
  background: rgba(39, 174, 96, 0.1);
  color: var(--success-color);
}

.status-delivered {
  background: rgba(46, 204, 113, 0.1);
  color: #2ecc71;
}

.status-billed {
  background: rgba(26, 188, 156, 0.1);
  color: #1abc9c;
}

.service-obs {
  margin-bottom: 1rem;
  padding: 0.5rem;
  background: #f8f9fa;
  border-radius: 8px;
  font-size: 0.85rem;
  color: var(--text-light);
}

.service-actions {
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
  text-decoration: none !important;
}

.action-btn.tree {
  background: #28a745 !important;
  color: white !important;
}

.action-btn.tree:hover {
  background: #218838 !important;
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

.action-btn.schedule {
  background: #17a2b8 !important;
  color: white !important;
}

.action-btn.schedule:hover {
  background: #138496 !important;
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
  
  .services-container {
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
  
  .service-card {
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

/* Estilos específicos do modal de agendamento */
.schedule-info {
  background: #e3f2fd;
  border: 1px solid #2196f3;
  border-radius: 8px;
  padding: 1rem;
  margin: 1rem 0;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #1976d2;
  font-size: 0.9rem;
}

/* Progresso no modal de agendamento */
.progress-info {
  text-align: center;
  margin: 1rem 0;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e9ecef;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-fill {
  height: 100%;
  background: #17a2b8;
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 0.9rem;
  color: #666;
}

/* Seção de resultado no modal */
.result-section {
  margin-top: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e9ecef;
}

.result-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.result-header h4 {
  margin: 0;
  color: #17a2b8;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.1rem;
}

.result-actions {
  display: flex;
  gap: 0.5rem;
}

.result-content {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 1rem;
  margin-bottom: 1rem;
  max-height: 200px;
  overflow-y: auto;
}

.result-text {
  margin: 0;
  font-family: 'Consolas', 'Monaco', monospace;
  font-size: 0.85rem;
  line-height: 1.4;
  white-space: pre-wrap;
  word-wrap: break-word;
  color: #333;
}

.result-stats {
  display: flex;
  gap: 1rem;
  font-size: 0.8rem;
  color: #666;
}

.stat {
  background: #f8f9fa;
  padding: 0.25rem 0.75rem;
  border-radius: 15px;
  border: 1px solid #e9ecef;
}

.btn-schedule {
  background: #17a2b8 !important;
  color: white !important;
  border: none !important;
  padding: 0.75rem 1.5rem !important;
  border-radius: 8px !important;
  font-weight: 600 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 0.5rem !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
}

.btn-schedule:hover:not(:disabled) {
  background: #138496 !important;
  transform: translateY(-2px) !important;
}

.btn-schedule:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none !important;
}

.spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
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
