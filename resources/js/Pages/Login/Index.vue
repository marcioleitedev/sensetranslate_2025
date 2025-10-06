<template>
  <div class="page-wrapper">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <Menu />

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
              <h1 class="hero-title">Área do Cliente</h1>
              <p class="hero-subtitle">Acesse sua conta para gerenciar seus projetos de tradução</p>
              <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-number">100%</span>
                  <span class="stat-label">Seguro</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">24/7</span>
                  <span class="stat-label">Acesso</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">SSL</span>
                  <span class="stat-label">Criptografia</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Login Section -->
    <section class="login-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8">
            
            <!-- Mensagem de sucesso/erro -->
            <div v-if="mensagem" class="alert-message" :class="{
                'alert-success': tipoMensagem === 'success',
                'alert-error': tipoMensagem === 'error'
            }">
              <i class="bi" :class="tipoMensagem === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'"></i>
              {{ mensagem }}
            </div>

            <!-- Login Card -->
            <div class="login-card">
              <div class="login-header">
                <div class="login-icon">
                  <i class="bi bi-person-circle"></i>
                </div>
                <h2>Fazer Login</h2>
                <p>Entre com suas credenciais para acessar sua conta</p>
              </div>

              <div class="login-body">
                <form @submit.prevent="login" class="login-form">
                  <div class="form-group">
                    <label for="email" class="form-label">
                      <i class="bi bi-envelope"></i>
                      E-mail
                    </label>
                    <input
                      type="email"
                      id="email"
                      class="form-control"
                      v-model="email"
                      required
                      placeholder="Digite seu e-mail"
                    />
                  </div>

                  <div class="form-group">
                    <label for="password" class="form-label">
                      <i class="bi bi-lock"></i>
                      Senha
                    </label>
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      v-model="password"
                      required
                      placeholder="Digite sua senha"
                    />
                  </div>

                  <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Entrar na Conta
                  </button>
                </form>

                <div class="login-links">
                  <a href="/forgot" class="forgot-link">
                    <i class="bi bi-question-circle"></i>
                    Esqueceu sua senha?
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <Footer />
  </div> 
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

<style scoped>
/* Reset e variáveis */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

:root {
  --primary-color: #e2b560;
  --secondary-color: #2c3e50;
  --accent-color: #3498db;
  --text-dark: #333;
  --text-light: #666;
  --bg-light: #f8f9fa;
  --shadow: 0 10px 30px rgba(0,0,0,0.1);
  --shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
  --success-color: #27ae60;
  --error-color: #e74c3c;
}

/* Container principal centralizado */
.page-wrapper {
  margin: 0 auto !important;
  padding: 0;
  min-height: 100vh;
  overflow-x: hidden;
  width: 100%;
  max-width: 100vw;
}

/* Containers Bootstrap centralizados */
.container {
  margin: 0 auto !important;
  padding-left: 15px !important;
  padding-right: 15px !important;
  max-width: 1200px !important;
  width: 100% !important;
}

/* Hero Section */
.hero-section {
  position: relative;
  height: 60vh;
  background: linear-gradient(135deg, rgba(44, 62, 80, 0.8), rgba(52, 152, 219, 0.6)), 
              url('/images/traducao-home.jpg') center/cover no-repeat fixed;
  display: flex;
  align-items: center;
  color: white;
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.3);
}

.hero-content {
  position: relative;
  z-index: 2;
  width: 100%;
}

.hero-title {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  font-weight: 300;
}

.hero-stats {
  display: flex;
  justify-content: center;
  gap: 3rem;
  margin-top: 2rem;
}

.stat-item {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 2rem;
  font-weight: 700;
  color: var(--primary-color);
  margin-bottom: 0.5rem;
}

.stat-label {
  color: #ecf0f1;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Login Section */
.login-section {
  padding: 80px 0;
  background: var(--bg-light);
  min-height: 60vh;
}

/* Alert Messages */
.alert-message {
  margin-bottom: 2rem;
  padding: 1rem 1.5rem;
  border-radius: 15px;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
  animation: slideDown 0.3s ease;
}

.alert-success {
  background: rgba(39, 174, 96, 0.1);
  color: var(--success-color);
  border: 1px solid rgba(39, 174, 96, 0.3);
}

.alert-error {
  background: rgba(231, 76, 60, 0.1);
  color: var(--error-color);
  border: 1px solid rgba(231, 76, 60, 0.3);
}

.alert-message i {
  font-size: 1.2rem;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Login Card */
.login-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow);
  margin-bottom: 2rem;
  transition: all 0.3s ease;
  color:gray;
}

.login-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.login-header {
  background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
  color: white;
  padding: 2.5rem 2rem;
  text-align: center;
}

.login-icon {
  width: 80px;
  height: 80px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  margin: 0 auto 1.5rem;
}

.login-header h2 {
  margin: 0 0 0.5rem 0;
  font-size: 2rem;
  font-weight: 700;
}

.login-header p {
  margin: 0;
  opacity: 0.9;
  font-size: 1rem;
}

.login-body {
  padding: 2.5rem;
}

/* Form Styles */
.login-form {
  margin-bottom: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  font-weight: 600 !important;
  color: var(--secondary-color) !important;
  margin-bottom: 0.75rem !important;
  font-size: 0.95rem !important;
}

.form-label i {
  font-size: 1rem !important;
  color: var(--primary-color) !important;
}

.form-control {
  width: 100% !important;
  padding: 1rem 1.25rem !important;
  border: 2px solid #e9ecef !important;
  border-radius: 15px !important;
  font-size: 1rem !important;
  transition: all 0.3s ease !important;
  background: white !important;
  color: var(--text-dark) !important;
}

.form-control:focus {
  outline: none !important;
  border-color: var(--primary-color) !important;
  background: white !important;
  color: var(--text-dark) !important;
  box-shadow: 0 0 0 3px rgba(226, 181, 96, 0.1) !important;
}

.form-control::placeholder {
  color: #6c757d !important;
}

/* Login Button */
.btn-login {
  width: 100% !important;
  padding: 1rem 2rem !important;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color)) !important;
  color: white !important;
  border: none !important;
  border-radius: 15px !important;
  font-size: 1.1rem !important;
  font-weight: 600 !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 0.75rem !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  text-decoration: none !important;
  outline: none !important;
  box-shadow: 0 4px 15px rgba(44, 62, 80, 0.2) !important;
}

.btn-login:hover,
.btn-login:focus,
.btn-login:active {
  background: linear-gradient(45deg, var(--secondary-color), var(--primary-color)) !important;
  color: white !important;
  transform: translateY(-2px) !important;
  box-shadow: 0 10px 25px rgba(44, 62, 80, 0.3) !important;
  text-decoration: none !important;
}

.btn-login i {
  font-size: 1.2rem !important;
  color: white !important;
}

/* Login Links */
.login-links {
  text-align: center;
  margin-top: 1.5rem;
}

.forgot-link {
  color: var(--accent-color);
  text-decoration: none;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
}

.forgot-link:hover {
  color: var(--secondary-color);
  transform: translateX(3px);
}

/* Responsividade */
@media (max-width: 1200px) {
  .hero-title { font-size: 2.5rem; }
}

@media (max-width: 992px) {
  .hero-title { font-size: 2rem; }
  .hero-subtitle { font-size: 1.1rem; }
  .hero-stats { gap: 2rem; }
}

@media (max-width: 768px) {
  .login-section { 
    padding: 60px 0; 
  }
  .hero-section { height: 50vh; }
  .hero-title { font-size: 1.8rem; }
  .hero-subtitle { font-size: 1rem; }
  .hero-stats { 
    flex-direction: column; 
    gap: 1rem; 
    text-align: center;
  }
  .login-header, .login-body {
    padding: 2rem 1.5rem;
  }
}

@media (max-width: 576px) {
  .login-section {
    padding: 40px 0;
  }
  .hero-section {
    height: 45vh;
  }
  .hero-title {
    font-size: 1.6rem;
  }
  .container {
    padding-left: 10px !important;
    padding-right: 10px !important;
  }
  .login-header, .login-body {
    padding: 1.5rem;
  }
}
</style>
