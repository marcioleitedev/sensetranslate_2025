<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <div class="d-flex"></div>

  <button class="btn btn-primary d-md-none toggle-btn" @click="showMobileMenu = !showMobileMenu">
    <i class="bi bi-list"></i>
  </button>

  <MenuLateral :showMobileMenu="showMobileMenu" @update:showMobileMenu="showMobileMenu = $event" />

  <main class="conteudo flex-grow-1 p-4">
    <h1 class="mb-4">Lista de Serviços</h1>

    <!-- Flash Message -->
    <div v-if="flashMessage" class="alert" :class="flashClass" role="alert">
      {{ flashMessage }}
    </div>

    <!-- Campo de busca -->
    <div class="input-group mb-3">
      <input
        type="text"
        class="form-control"
        placeholder="Buscar serviço..."
        v-model="search"
        @input="onSearchInput"
      />
      <button class="btn btn-outline-secondary" @click="clearSearch">Limpar</button>
    </div>

    <button class="btn btn-success mb-3" @click="openCreateModal">
      Criar Novo Serviço
    </button>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Preço</th>
          <th>Status</th>
          <th>Período</th>
          <th>Árvore</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="service in services.data" :key="service.id">
          <td>{{ service.id }}</td>
          <td>{{ service.name }}</td>
          <td>{{ service.price }}</td>
          <td>{{ statusMap[service.status] }}</td>
          <td>{{ formatDate(service.start) }} - {{ formatDate(service.end) }}</td>
          <td>
            <a :href="`/dashboard/arvore/${service.id}`" class="btn btn-outline-success btn-sm">
              <i class="bi bi-tree-fill"></i> Ver Árvore
            </a>
          </td>
          <td>
            <button class="btn btn-primary me-1" @click="openEditModal(service)">
              <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-danger" @click="removeService(service.id)">
              <i class="bi bi-trash3"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Paginação -->
    <nav v-if="services.meta">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: !services.links.prev }">
          <button class="page-link" @click="fetchServices(services.meta.current_page - 1)">Anterior</button>
        </li>
        <li class="page-item" v-for="page in services.meta.last_page" :key="page"
            :class="{ active: page === services.meta.current_page }">
          <button class="page-link" @click="fetchServices(page)">
            {{ page }}
          </button>
        </li>
        <li class="page-item" :class="{ disabled: !services.links.next }">
          <button class="page-link" @click="fetchServices(services.meta.current_page + 1)">Próxima</button>
        </li>
      </ul>
    </nav>

    <!-- Modal -->
    <div v-if="showModal">
      <div class="modal-backdrop fade show"></div>
      <div class="modal d-block" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ modalTitle }}</h5>
              <button type="button" class="btn-close" @click="closeModal"></button>
            </div>
            <div class="modal-body">
              <!-- Formulário do modal -->
  <form @submit.prevent="saveService">
  <div class="mb-3" v-for="field in formFields" :key="field.model">
    <label class="form-label">{{ field.label }}</label>

    <!-- Input -->
    <input
      v-if="field.type === 'input'"
      v-model="currentService[field.model]"
      :type="field.inputType"
      class="form-control"
    />

    <!-- Textarea -->
    <textarea
      v-else-if="field.type === 'textarea'"
      v-model="currentService[field.model]"
      :rows="field.rows"
      class="form-control"
    ></textarea>

    <!-- Select -->
    <select
      v-else-if="field.type === 'select'"
      v-model="currentService[field.model]"
      class="form-control"
    >
      <option v-for="option in field.options" :key="option.value" :value="option.value">
        {{ option.text }}
      </option>
    </select>

    <!-- Fallback -->
    <div v-else>
      <small class="text-muted">Tipo de campo "{{ field.type }}" não suportado.</small>
    </div>
  </div>

  <button type="submit" class="btn btn-success">{{ modalButtonText }}</button>
</form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import debounce from 'lodash.debounce';
import MenuLateral from '@/components/MenuLateral.vue';

const services = ref({});
const showModal = ref(false);
const modalTitle = ref('Criar Serviço');
const modalButtonText = ref('Salvar');
const search = ref('');
const showMobileMenu = ref(false);
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

const formatDate = (date) => {
  if (!date) return '';
  return new Date(date).toLocaleDateString('pt-BR');
};

onMounted(() => {
  fetchServices();
});
</script>

<style scoped>
.conteudo {
  margin-left: 220px;
  transition: margin-left 0.3s ease;
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
.modal {
  background-color: rgba(0, 0, 0, 0.5);
}
.modal-dialog {
  margin-top: 10vh;
}
</style>
