<template>
  <Head title="Evolution API Manager" />
  
  <div class="evolution-container">
    <!-- Back to Dashboard Button -->
    <div class="back-button-container">
      <a href="/dashboard" class="back-button">
        <i class="bi bi-arrow-left"></i>
        <span>Voltar ao Dashboard</span>
      </a>
    </div>

    <!-- Header -->
    <div class="evolution-header">
      <div class="header-content">
        <div class="header-icon">
          <i class="bi bi-chat-dots"></i>
        </div>
        <div class="header-text">
          <h1>Evolution API Manager</h1>
          <p>Gerencie suas instâncias do WhatsApp através da Evolution API</p>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="evolution-content">
      <div class="content-card">
        <div class="card-header">
          <h2><i class="bi bi-link-45deg"></i> Acesso ao Manager</h2>
        </div>
        
        <div class="card-body">
          <!-- URL Section -->
          <div class="info-section">
            <label class="info-label">
              <i class="bi bi-globe"></i>
              URL do Manager
            </label>
            <div class="info-content">
              <div class="url-display">
                <span class="url-text">{{ evolutionUrl }}</span>
                <button @click="copyUrl" class="copy-btn" :class="{ 'copied': urlCopied }">
                  <i class="bi" :class="urlCopied ? 'bi-check' : 'bi-clipboard'"></i>
                  {{ urlCopied ? 'Copiado!' : 'Copiar' }}
                </button>
              </div>
              <a :href="evolutionUrl" target="_blank" class="open-link">
                <i class="bi bi-box-arrow-up-right"></i>
                Abrir Evolution Manager
              </a>
            </div>
          </div>

          <!-- Password Section -->
          <div class="info-section">
            <label class="info-label">
              <i class="bi bi-key"></i>
              Senha de Acesso
            </label>
            <div class="info-content">
              <div class="password-display">
                <span class="password-text" :class="{ 'hidden': !showPassword }">
                  {{ showPassword ? password : '•'.repeat(password.length) }}
                </span>
                <div class="password-controls">
                  <button @click="togglePassword" class="toggle-btn">
                    <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                  </button>
                  <button @click="copyPassword" class="copy-btn" :class="{ 'copied': passwordCopied }">
                    <i class="bi" :class="passwordCopied ? 'bi-check' : 'bi-clipboard'"></i>
                    {{ passwordCopied ? 'Copiado!' : 'Copiar' }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Instructions -->
          <div class="instructions-section">
            <h3><i class="bi bi-info-circle"></i> Como usar</h3>
            <ul class="instructions-list">
              <li>Clique no botão "Abrir Evolution Manager" para acessar o painel</li>
              <li>Use a senha fornecida para fazer login no sistema</li>
              <li>No manager você poderá criar e gerenciar instâncias do WhatsApp</li>
              <li>Configure webhooks e monitore o status das conexões</li>
            </ul>
          </div>

          <!-- Quick Actions -->
          <div class="actions-section">
            <button @click="openManager" class="action-btn primary">
              <i class="bi bi-box-arrow-up-right"></i>
              Abrir Manager
            </button>
            <button @click="copyCredentials" class="action-btn secondary" :class="{ 'copied': credentialsCopied }">
              <i class="bi" :class="credentialsCopied ? 'bi-check' : 'bi-clipboard-data'"></i>
              {{ credentialsCopied ? 'Credenciais Copiadas!' : 'Copiar Tudo' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

// Props recebidas do controller
const props = defineProps({
  evolutionUrl: String,
  password: String
});

// Estado reativo
const showPassword = ref(false);
const urlCopied = ref(false);
const passwordCopied = ref(false);
const credentialsCopied = ref(false);

// Funções
const togglePassword = () => {
  showPassword.value = !showPassword.value;
};

const copyUrl = async () => {
  try {
    await navigator.clipboard.writeText(props.evolutionUrl);
    urlCopied.value = true;
    setTimeout(() => {
      urlCopied.value = false;
    }, 2000);
  } catch (err) {
    console.error('Erro ao copiar URL:', err);
  }
};

const copyPassword = async () => {
  try {
    await navigator.clipboard.writeText(props.password);
    passwordCopied.value = true;
    setTimeout(() => {
      passwordCopied.value = false;
    }, 2000);
  } catch (err) {
    console.error('Erro ao copiar senha:', err);
  }
};

const copyCredentials = async () => {
  const credentials = `URL: ${props.evolutionUrl}\nSenha: ${props.password}`;
  try {
    await navigator.clipboard.writeText(credentials);
    credentialsCopied.value = true;
    setTimeout(() => {
      credentialsCopied.value = false;
    }, 2000);
  } catch (err) {
    console.error('Erro ao copiar credenciais:', err);
  }
};

const openManager = () => {
  window.open(props.evolutionUrl, '_blank');
};
</script>

<style scoped>
.evolution-container {
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 2rem;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.back-button-container {
  margin-bottom: 1rem;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(255, 255, 255, 0.15);
  color: #fff;
  text-decoration: none;
  padding: 0.75rem 1.5rem;
  border-radius: 0.5rem;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
  font-weight: 500;
}

.back-button:hover {
  background: rgba(255, 255, 255, 0.25);
  color: #fff;
  transform: translateX(-2px);
  text-decoration: none;
}

.evolution-header {
  text-align: center;
  margin-bottom: 3rem;
}

.header-content {
  display: inline-flex;
  align-items: center;
  gap: 1rem;
  background: rgba(255, 255, 255, 0.1);
  padding: 1.5rem 2rem;
  border-radius: 1rem;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.header-icon {
  font-size: 3rem;
  color: #fff;
}

.header-text h1 {
  color: #fff;
  margin: 0;
  font-size: 2.5rem;
  font-weight: 700;
}

.header-text p {
  color: rgba(255, 255, 255, 0.8);
  margin: 0.5rem 0 0 0;
  font-size: 1.1rem;
}

.evolution-content {
  max-width: 800px;
  margin: 0 auto;
}

.content-card {
  background: #fff;
  border-radius: 1rem;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.card-header {
  background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  color: #fff;
  padding: 1.5rem 2rem;
  text-align: center;
}

.card-header h2 {
  margin: 0;
  font-size: 1.5rem;
  font-weight: 600;
}

.card-body {
  padding: 2rem;
}

.info-section {
  margin-bottom: 2rem;
}

.info-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: #333;
  margin-bottom: 1rem;
  font-size: 1.1rem;
}

.info-content {
  background: #f8f9fa;
  border-radius: 0.5rem;
  padding: 1rem;
  border: 1px solid #e9ecef;
}

.url-display, .password-display {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.url-text {
  flex: 1;
  font-family: 'Courier New', monospace;
  background: #fff;
  padding: 0.75rem;
  border-radius: 0.25rem;
  border: 1px solid #ddd;
  font-size: 0.9rem;
  word-break: break-all;
}

.password-text {
  flex: 1;
  font-family: 'Courier New', monospace;
  background: #fff;
  padding: 0.75rem;
  border-radius: 0.25rem;
  border: 1px solid #ddd;
  font-size: 0.9rem;
  transition: all 0.3s ease;
}

.password-text.hidden {
  letter-spacing: 0.2rem;
}

.password-controls {
  display: flex;
  gap: 0.5rem;
}

.copy-btn, .toggle-btn {
  background: #007bff;
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.copy-btn:hover, .toggle-btn:hover {
  background: #0056b3;
  transform: translateY(-1px);
}

.copy-btn.copied {
  background: #28a745;
}

.toggle-btn {
  background: #6c757d;
}

.toggle-btn:hover {
  background: #545b62;
}

.open-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: #25D366;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.open-link:hover {
  color: #128C7E;
  transform: translateX(2px);
}

.instructions-section {
  background: #e3f2fd;
  border-radius: 0.5rem;
  padding: 1.5rem;
  margin-bottom: 2rem;
  border-left: 4px solid #2196f3;
}

.instructions-section h3 {
  color: #1976d2;
  margin: 0 0 1rem 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.instructions-list {
  margin: 0;
  padding-left: 1.5rem;
  color: #333;
}

.instructions-list li {
  margin-bottom: 0.5rem;
  line-height: 1.5;
}

.actions-section {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.action-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem 2rem;
  border: none;
  border-radius: 0.5rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  font-size: 1rem;
}

.action-btn.primary {
  background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  color: #fff;
}

.action-btn.primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
}

.action-btn.secondary {
  background: #6c757d;
  color: #fff;
}

.action-btn.secondary:hover {
  background: #545b62;
  transform: translateY(-2px);
}

.action-btn.secondary.copied {
  background: #28a745;
}

@media (max-width: 768px) {
  .evolution-container {
    padding: 1rem;
  }
  
  .header-content {
    flex-direction: column;
    text-align: center;
  }
  
  .header-text h1 {
    font-size: 2rem;
  }
  
  .card-body {
    padding: 1rem;
  }
  
  .url-display, .password-display {
    flex-direction: column;
    align-items: stretch;
  }
  
  .password-controls {
    justify-content: center;
  }
  
  .actions-section {
    flex-direction: column;
  }
  
  .action-btn {
    width: 100%;
    justify-content: center;
  }
}
</style>