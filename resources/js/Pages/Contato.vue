<template>
  <Menu /> <!-- Componente Menu incluído -->

  <div class="container">
    <h1>Fale Conosco</h1>
    <p>Entre em contato conosco pelo formulário abaixo:</p>
    <form @submit.prevent="enviarFormulario">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" v-model="nome" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" v-model="email" required>

      <button type="submit">Enviar</button>
    </form>
  </div>
</template>

<script setup>
import Menu from '@/Components/Menu.vue';
import { ref } from "vue";

const nome = ref("");
const email = ref("");

const enviarFormulario = () => {
  alert(`Obrigado pelo contato, ${nome.value}!`);
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 50px auto;
  text-align: center;
}

form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

input,
button {
  padding: 10px;
}
</style>
