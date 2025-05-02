<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <div class="d-flex">
    <!-- Botão Menu Mobile -->
    <button class="btn btn-primary d-md-none toggle-btn" @click="showMobileMenu = !showMobileMenu">
      <i class="bi bi-list"></i>
    </button>

    <!-- Menu Lateral -->
    <MenuLateral :showMobileMenu="showMobileMenu" @update:showMobileMenu="showMobileMenu = $event" />

    <main class="conteudo flex-grow-1 p-4">
      <h1>Orçamentos</h1>

      <!-- Flash Message -->
      <div v-if="flashMessage" class="alert" :class="flashType" role="alert">
        {{ flashMessage }}
      </div>

      <!-- Botão de Cadastro -->
      <button class="btn btn-success mb-3 ms-auto d-flex" @click="showCreateModal = true">
        <i class="bi bi-file-earmark-plus me-2"></i> Criar Orçamento
      </button>

      <!-- Campo de busca -->
      <div class="d-flex justify-content-end mb-3">
        <input
          v-model="searchTerm"
          type="text"
          class="form-control w-50"
          placeholder="Buscar por nome, e-mail, telefone..."
        />
      </div>

      <!-- Tabela de Orçamentos -->
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Preço</th>
            <th>Whatsapp</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="budget in budgets.data" :key="budget.id">
            <td>{{ budget.id }}</td>
            <td>{{ budget.name }}</td>
            <td>{{ budget.email }}</td>
            <td>{{ budget.phone }}</td>
            <td>{{ budget.price }}</td>
            <td>
              <a
    :href="getWhatsAppLink(budget.phone, budget.content)"
    target="_blank"
    class="btn btn-success btn-sm"
  >
    <i class="bi bi-whatsapp"></i> Enviar
  </a>
            </td>
            <td>{{ getStatusName(budget.status) }}</td>
            <td>
              <button class="btn btn-primary me-1" @click="openEditModal(budget)">
                <i class="bi bi-pencil-square"></i> Editar
              </button>
              <button class="btn btn-danger" @click="removeBudget(budget.id)">
                <i class="bi bi-trash3"></i> Remover
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginação -->
      <nav>
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: !budgets.prev_page_url }">
            <a class="page-link" href="#" @click.prevent="fetchBudgets(budgets.prev_page_url)">Anterior</a>
          </li>
          <li class="page-item" v-for="page in paginationLinks" :key="page.label" :class="{ active: page.active }">
            <a class="page-link" href="#" @click.prevent="fetchBudgets(page.url)">
              {{ page.label }}
            </a>
          </li>
          <li class="page-item" :class="{ disabled: !budgets.next_page_url }">
            <a class="page-link" href="#" @click.prevent="fetchBudgets(budgets.next_page_url)">Próximo</a>
          </li>
        </ul>
      </nav>

      <!-- Modal de Criação -->
      <div class="modal fade show d-block" tabindex="-1" v-if="showCreateModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Criar Orçamento {{  user.id }}</h5>
              <button type="button" class="btn-close" @click="showCreateModal = false"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="createBudget">
                <div class="mb-3" v-for="(label, key) in fields" :key="key">
                  <label class="form-label">{{ label }}</label>
                  <input v-model="newBudget[key]" :type="key === 'email' ? 'email' : key === 'price' ? 'number' : 'text'" class="form-control" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Conteúdo do Orçamento (HTML)</label>
                  <quill-editor v-model:content="newBudget.content" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select v-model="newBudget.status" class="form-select">
                    <option value="1">Pendente</option>
                    <option value="2">Aprovado</option>
                    <option value="3">Rejeitado</option>
                  </select>
                </div>
                <input type="hidden" :value="user.id" name="user_id" />

                <button type="submit" class="btn btn-success">Salvar</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal de Edição -->
      <div class="modal fade show d-block" tabindex="-1" v-if="showEditModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Editar Orçamento </h5>
              <button type="button" class="btn-close" @click="showEditModal = false"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="updateBudget">
                <div class="mb-3" v-for="(label, key) in fields" :key="key">
                  <label class="form-label">{{ label }}</label>
                  <input v-model="budgetToEdit[key]" :type="key === 'email' ? 'email' : key === 'price' ? 'number' : 'text'" class="form-control" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Conteúdo do Orçamento (HTML)</label>
                  <quill-editor v-model:content="budgetToEdit.content" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select v-model="budgetToEdit.status" class="form-select">
                    <option value="1">Pendente</option>
                    <option value="2">Aprovado</option>
                    <option value="3">Rejeitado</option>
                  </select>
                </div>

 
                <button type="submit" class="btn btn-primary">Atualizar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, watch , onMounted } from 'vue';
import axios from 'axios';
import debounce from 'lodash.debounce';
import MenuLateral from '@/components/MenuLateral.vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { jwtDecode } from 'jwt-decode'

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
  price: 'Preço',
  content: 'Content'
};

const getStatusName = (status) => {
  switch (status) {
    case 1: return 'Pendente';
    case 2: return 'Aprovado';
    case 3: return 'Rejeitado';
    default: return 'Desconhecido';
  }
};

const getWhatsAppLink = (phone, content) => {
  const cleaned = phone.replace(/\D/g, '');
  const encodedContent = encodeURIComponent(content); // Codifica o conteúdo para ser usado na URL
  return `https://wa.me/55${cleaned}?text=${encodedContent}`;
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

    newBudget.value.user_id = user.value.id; // garante que é número
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
  budgetToEdit.value = { ...budget };
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
.modal {
  background: rgba(0, 0, 0, 0.5);
}

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
</style>
