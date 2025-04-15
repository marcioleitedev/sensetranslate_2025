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
      <h1>Bem-vindo à Dashboard</h1>
      <p>Este é o conteúdo principal da página.</p>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import MenuLateral from '@/components/MenuLateral.vue'

const showMobileMenu = ref(false)
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
