<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <div class="d-flex">
    <!-- Botão toggle mobile -->
    <button
      class="btn btn-primary d-md-none toggle-btn"
      @click="showMobileMenu = !showMobileMenu"
    >
      <i class="bi bi-list"></i>
    </button>

    <!-- Menu Component -->
    <MenuLateral
  :showMobileMenu="showMobileMenu"
  @update:showMobileMenu="showMobileMenu = $event"
/>

    <!-- Conteúdo -->
    <main class="conteudo flex-grow-1 p-4">
      <h1>Bem-vindo à Dashboard  </h1>
      <h3>{{  user.name }}</h3>
      <p>Este é o conteúdo principal da página. </p>
    </main>
  </div>
</template>

<script setup>
import {  ref, onMounted } from 'vue'
import axios from 'axios'

import MenuLateral from '@/components/MenuLateral.vue'

const showMobileMenu = ref(false)
import { jwtDecode } from 'jwt-decode'


const isAuthenticated = ref(false)
const user = ref({
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
