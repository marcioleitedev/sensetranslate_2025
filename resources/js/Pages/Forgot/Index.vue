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
              <h1 class="hero-title">Recuperar Senha</h1>
              <p class="hero-subtitle">Não se preocupe! Vamos ajudá-lo a recuperar o acesso à sua conta</p>
              <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-number">100%</span>
                  <span class="stat-label">Seguro</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">2min</span>
                  <span class="stat-label">Processo</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">24h</span>
                  <span class="stat-label">Suporte</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Forgot Password Section -->
    <section class="forgot-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-7">
            
            <!-- Mensagem de sucesso/erro -->
            <div v-if="message" class="alert-message" :class="{
                'alert-success': !isError,
                'alert-error': isError
            }">
              <i class="bi" :class="!isError ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'"></i>
              {{ message }}
            </div>

            <!-- Forgot Password Card -->
            <div class="forgot-card">
              <div class="forgot-header">
                <div class="forgot-icon">
                  <i class="bi bi-key-fill"></i>
                </div>
                <h2>Esqueceu sua Senha?</h2>
                <p>Digite seu e-mail e enviaremos um link para redefinir sua senha</p>
              </div>

              <div class="forgot-body">
                <form @submit.prevent="submit" class="forgot-form">
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
                      placeholder="Digite seu e-mail cadastrado"
                    />
                  </div>

                  <button type="submit" class="btn-forgot">
                    <i class="bi bi-send-fill"></i>
                    Enviar Link de Recuperação
                  </button>
                </form>

                <div class="back-to-login">
                  <a href="/login" class="back-link">
                    <i class="bi bi-arrow-left"></i>
                    Voltar ao Login
                  </a>
                </div>
              </div>
            </div>

            <!-- Help Card -->
            <div class="help-card">
              <div class="help-content">
                <h4>Precisa de Ajuda?</h4>
                <p>Se você não receber o e-mail em alguns minutos, verifique sua pasta de spam ou entre em contato conosco.</p>
                <div class="help-actions">
                  <a href="/contato" class="help-btn">
                    <i class="bi bi-headset"></i>
                    Falar com Suporte
                  </a>
                  <a href="mailto:comercial@sensetranslate.com" class="help-btn">
                    <i class="bi bi-envelope"></i>
                    Enviar E-mail
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
import { ref } from 'vue'
import axios from 'axios'
import Menu from '@/Components/Menu.vue'
import Footer from '@/Components/Footer.vue'

const email = ref('')
const message = ref('')
const isError = ref(false)

const submit = async () => {
  try {
    message.value = ''
    isError.value = false
    
    const response = await axios.post('http://127.0.0.1:8000/api/forgot-password', { 
      email: email.value 
    })
    
    message.value = 'Link de redefinição enviado para seu e-mail com sucesso!'
    isError.value = false
    
    // Limpar o campo após sucesso
    email.value = ''
    
  } catch (error) {
    if (error.response && error.response.data && error.response.data.message) {
      message.value = error.response.data.message
    } else {
      message.value = 'Erro ao enviar link. Verifique seu e-mail e tente novamente.'
    }
    isError.value = true
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

/* Forgot Password Section */
.forgot-section {
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

/* Forgot Password Card */
.forgot-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow);
  margin-bottom: 2rem;
  transition: all 0.3s ease;
}

.forgot-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.forgot-header {
  background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
  color: white;
  padding: 2.5rem 2rem;
  text-align: center;
}

.forgot-icon {
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

.forgot-header h2 {
  margin: 0 0 0.5rem 0;
  font-size: 2rem;
  font-weight: 700;
}

.forgot-header p {
  margin: 0;
  opacity: 0.9;
  font-size: 1rem;
}

.forgot-body {
  padding: 2.5rem;
}

/* Form Styles */
.forgot-form {
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

/* Forgot Button */
.btn-forgot {
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

.btn-forgot:hover,
.btn-forgot:focus,
.btn-forgot:active {
  background: linear-gradient(45deg, var(--secondary-color), var(--primary-color)) !important;
  color: white !important;
  transform: translateY(-2px) !important;
  box-shadow: 0 10px 25px rgba(44, 62, 80, 0.3) !important;
  text-decoration: none !important;
}

.btn-forgot i {
  font-size: 1.2rem !important;
  color: white !important;
}

/* Back to Login */
.back-to-login {
  text-align: center;
  margin-top: 1.5rem;
}

.back-link {
  color: var(--accent-color);
  text-decoration: none;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
}

.back-link:hover {
  color: var(--secondary-color);
  transform: translateX(-3px);
}

/* Help Card */
.help-card {
  background: white;
  border-radius: 20px;
  padding: 2rem;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
}

.help-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.help-content h4 {
  color: var(--secondary-color);
  margin-bottom: 1rem;
  text-align: center;
  font-weight: 700;
}

.help-content p {
  color: var(--text-light);
  margin-bottom: 1.5rem;
  text-align: center;
  line-height: 1.6;
}

.help-actions {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1rem;
}

.help-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem;
  background: var(--bg-light);
  border-radius: 15px;
  text-decoration: none;
  color: var(--secondary-color);
  transition: all 0.3s ease;
  text-align: center;
  font-weight: 500;
}

.help-btn:hover {
  background: var(--primary-color);
  color: white;
  transform: translateY(-3px);
}

.help-btn i {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
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
  .forgot-section { 
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
  .forgot-header, .forgot-body {
    padding: 2rem 1.5rem;
  }
  .help-actions {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 576px) {
  .forgot-section {
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
  .forgot-header, .forgot-body {
    padding: 1.5rem;
  }
  .help-card {
    padding: 1.5rem;
  }
}
</style>
