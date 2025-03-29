<template>

  <Menu /> <!-- Componente Menu incluído -->
  <div class="container text-center">
    <h1 class="mt-5 text-primary">Bem-vindo à Loja de Serviços</h1>
    <p class="lead">Escolha um serviço e aproveite!</p>
    <button class="btn btn-success custom-btn">Clique aqui</button>
  </div>
</template>

<script setup>
import Menu from '@/Components/Menu.vue'; 
</script>

<style scoped>
/* CSS adicional para o componente */
.container {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
}

.text-primary {
  color: #007bff !important;
}

.custom-btn {
  background-color: #28a745;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 5px;
}

.custom-btn:hover {
  background-color: #218838;
}
</style>
