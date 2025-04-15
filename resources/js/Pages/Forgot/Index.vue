<template>
    <Menu />
  <div class="forgot-password">
    <h2>Esqueci minha senha</h2>
    <form @submit.prevent="submit">
      <input v-model="email" type="email" className="form-control" placeholder="Digite seu e-mail" required />
      <button type="submit" className="btn btn-success m-3">Enviar link</button>
    </form>
    <p v-if="message">{{ message }}</p>
  </div>

  <Footer />
</template>

<script setup>
import Menu from '@/Components/Menu.vue'; 
import Footer from '@/Components/Footer.vue'; 
</script>

<script>

import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      message: '',
    };
  },
  methods: {
    async submit() {
      try {
        await axios.post('/api/forgot-password', { email: this.email });
        this.message = 'Link de redefinição enviado para seu e-mail.';
      } catch (error) {
        this.message = 'Erro ao enviar link.';
      }
    },
  },
};



</script>

<style scoped>
.forgot-password {
  max-width: 400px;
  margin: auto;
  margin-top: 200px;
  margin-bottom: 200px;
}
</style>
