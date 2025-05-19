<template>
  <aside :class="['menu-lateral', { 'collapsed': isCollapsed, 'show': showMobileMenu }]">
    <div class="d-flex justify-content-between align-items-center px-3 py-2">
      <h5 class="text-white m-0" v-if="!isCollapsed">Menu</h5>
    
      <button class="btn btn-sm btn-light" @click="toggleCollapse">
        <i class="bi" :class="isCollapsed ? 'bi-arrow-right' : 'bi-arrow-left'"></i>
      </button>
    
    </div>
    <div class="flex-column px-2">
      <h3 class="text-white fs-6">{{  user.name }}</h3>
    </div>

    <ul class="nav flex-column px-2">
      <li class="nav-item">
        <a class="nav-link text-white" href="/dashboard">
          <i class="bi bi-speedometer2 me-2"></i>
          <span v-if="!isCollapsed">Dashboard</span>
        </a>
      </li>
      <li class="nav-item" v-if="user.level === 3" >
        <a class="nav-link text-white" href="/dashboard/usuarios">
          <i class="bi bi-person-arms-up me-2"></i>
          <span v-if="!isCollapsed">Usuários</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="/dashboard/orcamentos">
          <i class="bi bi-filetype-pdf me-2"></i>
          <span v-if="!isCollapsed">Orçamentos</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="/dashboard/servicos">
          <i class="bi bi-person-gear me-2"></i>
          <span v-if="!isCollapsed">Serviços</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#" @click.prevent="logout">
          <i class="bi bi-box-arrow-right me-2"></i>
          <span v-if="!isCollapsed">Sair</span>
        </a>
      </li>
    </ul>
  </aside>
</template>

<script setup>
import { defineProps, defineEmits, ref, onMounted, onBeforeUnmount } from 'vue'
import axios from 'axios'

import { jwtDecode } from 'jwt-decode'


const isAuthenticated = ref(false)
const user = ref({
  name: '',
  email: '',
  level: null,
  decodedToken: null,
})


const props = defineProps({
  showMobileMenu: Boolean
})
const emit = defineEmits(['update:showMobileMenu'])

const isCollapsed = ref(false)


// Toggle do menu lateral
const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value
}

// Função para fechar o menu no mobile ao clicar fora
const handleClickOutside = (e) => {
  const menu = document.querySelector('.menu-lateral')
  if (props.showMobileMenu && menu && !menu.contains(e.target) && !e.target.closest('.toggle-btn')) {
    emit('update:showMobileMenu', false)
  }
}

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

// Função para buscar o usuário autenticado
const getUser = async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) throw new Error('Token não encontrado')

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    const { data } = await axios.get('http://localhost:8000/api/me') 
    user.value = data
  } catch (error) {
    logout() 
  }
}

// Função de logout
const logout = () => {
  localStorage.removeItem('token')
  delete axios.defaults.headers.common['Authorization']
  window.location.href = '/login' // Redireciona para a página de login
}

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style>
.menu-lateral {
  width: 220px;
  min-height: 100vh;
  background-color: #1b5a9e;
  position: fixed;
  top: 0;
  left: 0;
  transition: all 0.3s ease;
  z-index: 1000;
}

.menu-lateral.collapsed {
  width: 60px;
}

.menu-lateral .nav-link {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.menu-lateral.collapsed .nav-link {
  text-align: center;
}

.menu-lateral .nav-link span {
  display: inline;
}

.menu-lateral.collapsed .nav-link span {
  display: none;
}

/* MOBILE */
@media (max-width: 700px) {
  .menu-lateral {
    transform: translateX(-100%);
  }

  .menu-lateral.show {
    transform: translateX(0%);
  }

  .menu-lateral.collapsed {
    width: 220px;
  }

  .menu-lateral.collapsed .nav-link span {
    display: inline;
  }
}
</style>
