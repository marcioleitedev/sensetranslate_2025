<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <div class="d-flex">
    <!-- Botão toggle mobile -->
    <button class="btn btn-primary d-md-none toggle-btn" @click="showMobileMenu = !showMobileMenu">
      <i class="bi bi-list"></i>
    </button>

    <!-- Menu Component -->
    <MenuLateral
      :showMobileMenu="showMobileMenu"
      @update:showMobileMenu="showMobileMenu = $event"
    />

    <!-- Conteúdo -->
    <main class="conteudo flex-grow-1 p-4">
      <h1>Usuários</h1>

      <!-- Botão de Cadastro -->
      <button class="btn btn-success mb-3 ms-auto d-flex" @click="showCreateModal = true">
        <i class="bi bi-person-add"></i> Cadastrar Usuário
      </button>

      <!-- Tabela de Usuários -->
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Nível</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ getLevelName(user.level) }}</td>
            <td>
              <button class="btn btn-primary me-1" @click="openEditModal(user)">
                <i class="bi bi-pencil-square"></i> Editar
              </button>
              <button class="btn btn-danger" @click="removeUser(user.id)">
                <i class="bi bi-trash3"></i> Remover
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginação -->
      <nav>
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: !users.prev_page_url }">
            <a class="page-link" href="#" @click.prevent="fetchUsers(users.prev_page_url)">Anterior</a>
          </li>
          <li
            class="page-item"
            v-for="page in paginationLinks"
            :key="page.label"
            :class="{ active: page.active }"
          >
            <a class="page-link" href="#" @click.prevent="fetchUsers(page.url)">
              {{ page.label }}
            </a>
          </li>
          <li class="page-item" :class="{ disabled: !users.next_page_url }">
            <a class="page-link" href="#" @click.prevent="fetchUsers(users.next_page_url)">Próximo</a>
          </li>
        </ul>
      </nav>

      <!-- Modal de Cadastro -->
      <div v-if="showCreateModal" class="modal" tabindex="-1" style="display: block;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Cadastrar Usuário</h5>
              <button type="button" class="btn-close" @click="showCreateModal = false"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="createUser">
                <div class="mb-3">
                  <label for="name" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="name" v-model="newUser.name" required />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" v-model="newUser.email" required />
                </div>
                <div class="mb-3">
                  <label for="level" class="form-label">Nível</label>
                  <select class="form-control" id="level" v-model="newUser.level" required>
                    <option value="1">Usuário</option>
                    <option value="2">Funcionário</option>
                    <option value="3">Administrador</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-success">Cadastrar</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal de Edição -->
      <div v-if="showEditModal" class="modal" tabindex="-1" style="display: block;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Editar Usuário</h5>
              <button type="button" class="btn-close" @click="showEditModal = false"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="updateUser">
                <div class="mb-3">
                  <label for="editName" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="editName" v-model="userToEdit.name" required />
                </div>
                <div class="mb-3">
                  <label for="editEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="editEmail" v-model="userToEdit.email" required />
                </div>
                <div class="mb-3">
                  <label for="editLevel" class="form-label">Nível</label>
                  <select class="form-control" id="editLevel" v-model="userToEdit.level" required>
                    <option value="1">Usuário</option>
                    <option value="2">Funcionário</option>
                    <option value="3">Administrador</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-warning">Salvar alterações</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MenuLateral from '@/components/MenuLateral.vue';

const showMobileMenu = ref(false);
const showCreateModal = ref(false);
const showEditModal = ref(false);

const newUser = ref({ name: '', email: '', level: 1 });
const userToEdit = ref({ id: null, name: '', email: '', level: 1 });

const users = ref([]);
const paginationLinks = ref([]);

// Obter nome do nível
const getLevelName = (level) => {
  switch (level) {
    case 1: return 'Cliente';
    case 2: return 'Funcionário';
    case 3: return 'Administrador';
    default: return 'Desconhecido';
  }
};

// Buscar usuários
const fetchUsers = async (url = 'http://localhost:8000/api/usuarios') => {
  try {
    const response = await axios.get(url);
    users.value = response.data;
    paginationLinks.value = response.data.links;
  } catch (error) {
    console.error('Erro ao buscar usuários:', error);
  }
};

// Criar novo usuário
const createUser = async () => {
  try {
    await axios.post('http://localhost:8000/api/usuarios', newUser.value);
    showCreateModal.value = false;
    fetchUsers();
  } catch (error) {
    console.error('Erro ao cadastrar usuário:', error);
  }
};

// Abrir modal de edição
const openEditModal = (user) => {
  userToEdit.value = { ...user };
  showEditModal.value = true;
};

// Atualizar usuário
const updateUser = async () => {
  try {
    await axios.put(`http://localhost:8000/api/usuarios/${userToEdit.value.id}`, userToEdit.value);
    showEditModal.value = false;
    fetchUsers();
  } catch (error) {
    console.error('Erro ao atualizar usuário:', error);
  }
};

// Remover usuário
const removeUser = async (userId) => {
  try {
    await axios.delete(`http://localhost:8000/api/usuarios/${userId}`);
    fetchUsers();
  } catch (error) {
    console.error('Erro ao remover usuário:', error);
  }
};

onMounted(fetchUsers);
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
</style>
