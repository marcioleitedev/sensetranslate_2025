<template>
    <Menu /> 
    <div class="container mt-5">
        <!-- Mensagem de sucesso/erro -->
        <div v-if="mensagem" class="alert" :class="{
            'alert-success': tipoMensagem === 'success',
            'alert-danger': tipoMensagem === 'error'
        }" role="alert">
            {{ mensagem }}
        </div>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <h2 class="text-center mb-4">Login</h2>
    <form @submit.prevent="login">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          id="email"
          class="form-control"
          v-model="email"
          required
          placeholder="Digite seu email"
        />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input
          type="password"
          id="password"
          class="form-control"
          v-model="password"
          required
          placeholder="Digite sua senha"
        />
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
    <div class="text-center mt-3">
      <small><a href="/forgot">Esqueceu a senha?</a></small>
    </div>
  </div>
  
</div>

<div class="text-center mt-4">
  <h3>Login com sua Rede Social:</h3>
  <button class="btn btn-outline-danger w-100 mb-2" @click="socialLogin('google')">Google</button>
  <!-- <button class="btn btn-outline-primary w-100 mb-2" @click="socialLogin('facebook')">Facebook</button>
  <button class="btn btn-outline-info w-100 mb-2" @click="socialLogin('linkedin')">LinkedIn</button> -->
</div>

    </div>


    <Footer /> 
</template>

<script setup>
// import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
import Menu from '@/Components/Menu.vue'
import Footer from '@/Components/Footer.vue'

const email = ref('')
const password = ref('')
const mensagem = ref('')
const tipoMensagem = ref('')

const socialLogin = (provider) => {
    window.location.href = `http://127.0.0.1:8000/api/auth/${provider}/redirect`
}

const login = async () => {
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
            email: email.value,
            password: password.value
        })

        localStorage.setItem('token', response.data.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`

        mensagem.value = 'Login realizado com sucesso!'
        tipoMensagem.value = 'success'

        setTimeout(() => {
            router.visit('/dashboard')  
        }, 1500)
    } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
            mensagem.value = error.response.data.message
        } else {
            mensagem.value = 'Erro ao fazer login. Verifique suas credenciais.'
        }
        tipoMensagem.value = 'error'
    }
}


</script>
