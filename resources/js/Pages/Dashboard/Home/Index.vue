<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <div class="dashboard-wrapper">
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

    <!-- Conteúdo Principal -->
    <main class="dashboard-content">
      
      <!-- Header da Dashboard -->
      <div class="dashboard-header">
        <div class="header-content">
          <div class="welcome-section">
            <h1 class="welcome-title">
              <i class="bi bi-house-door-fill"></i>
              Bem-vindo, {{ user.name }}!
            </h1>
            <p class="welcome-subtitle">
              <i class="bi bi-shield-check"></i>
              Nível de acesso: <span class="user-level">{{ user.level }}</span>
            </p>
          </div>
          <div class="header-stats">
            <div class="stat-card">
              <div class="stat-icon">
                <i class="bi bi-calendar-check"></i>
              </div>
              <div class="stat-info">
                <span class="stat-number">{{ getCurrentDate() }}</span>
                <span class="stat-label">Hoje</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Cards de Estatísticas -->
      <div class="stats-section">
        <div class="stats-grid">
          <div class="stat-card large">
            <div class="stat-icon projects">
              <i class="bi bi-folder-fill"></i>
            </div>
            <div class="stat-content">
              <h3 class="stat-title">Projetos</h3>
              <p class="stat-number">-</p>
              <p class="stat-description">Sistema em desenvolvimento</p>
            </div>
          </div>

          <div class="stat-card large">
            <div class="stat-icon clients">
              <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-content">
              <h3 class="stat-title">Usuários</h3>
              <p class="stat-number">-</p>
              <p class="stat-description">Cadastros do sistema</p>
            </div>
          </div>

          <div class="stat-card large">
            <div class="stat-icon revenue">
              <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="stat-content">
              <h3 class="stat-title">Relatórios</h3>
              <p class="stat-number">-</p>
              <p class="stat-description">Em breve</p>
            </div>
          </div>

          <div class="stat-card large">
            <div class="stat-icon completed">
              <i class="bi bi-gear-fill"></i>
            </div>
            <div class="stat-content">
              <h3 class="stat-title">Sistema</h3>
              <p class="stat-number">v1.0</p>
              <p class="stat-description">Versão atual</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Ações Rápidas -->
      <div class="quick-actions-section">
        <h2 class="section-title">
          <i class="bi bi-lightning-fill"></i>
          Ações Rápidas
        </h2>
        <div class="actions-grid">
          <a href="/dashboard/orcamentos" class="action-card">
            <div class="action-icon">
              <i class="bi bi-calculator"></i>
            </div>
            <div class="action-content">
              <h4>Orçamentos</h4>
              <p>Gerenciar cotações</p>
            </div>
            <i class="bi bi-arrow-right action-arrow"></i>
          </a>

          <a href="/dashboard/usuarios" class="action-card">
            <div class="action-icon">
              <i class="bi bi-person-plus"></i>
            </div>
            <div class="action-content">
              <h4>Usuários</h4>
              <p>Gerenciar usuários</p>
            </div>
            <i class="bi bi-arrow-right action-arrow"></i>
          </a>

          <a href="/dashboard/servicos" class="action-card">
            <div class="action-icon">
              <i class="bi bi-gear"></i>
            </div>
            <div class="action-content">
              <h4>Serviços</h4>
              <p>Configurações do sistema</p>
            </div>
            <i class="bi bi-arrow-right action-arrow"></i>
          </a>

          <a href="/contato" class="action-card">
            <div class="action-icon">
              <i class="bi bi-headset"></i>
            </div>
            <div class="action-content">
              <h4>Suporte</h4>
              <p>Ajuda e documentação</p>
            </div>
            <i class="bi bi-arrow-right action-arrow"></i>
          </a>
        </div>
      </div>

      <!-- Atividades Recentes -->
      <div class="recent-activity-section">
        <h2 class="section-title">
          <i class="bi bi-clock-history"></i>
          Últimas Atividades
        </h2>
        <div class="activity-list">
          <div class="activity-item">
            <div class="activity-icon info">
              <i class="bi bi-person-check"></i>
            </div>
            <div class="activity-content">
              <h5>Usuário logado</h5>
              <p>{{ user.name }} acessou o sistema</p>
              <span class="activity-time">Agora</span>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon success">
              <i class="bi bi-shield-check"></i>
            </div>
            <div class="activity-content">
              <h5>Sistema operacional</h5>
              <p>Todos os serviços funcionando normalmente</p>
              <span class="activity-time">Sistema ativo</span>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon info">
              <i class="bi bi-gear"></i>
            </div>
            <div class="activity-content">
              <h5>Dashboard atualizado</h5>
              <p>Interface modernizada com novo design</p>
              <span class="activity-time">Recente</span>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import MenuLateral from '@/Components/MenuLateral.vue'
import { jwtDecode } from 'jwt-decode'

const showMobileMenu = ref(false)

const isAuthenticated = ref(false)
const user = ref({
  name: '',
  email: '',
  level: null,
  decodedToken: null,
})

const getCurrentDate = () => {
  const today = new Date()
  return today.toLocaleDateString('pt-BR', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
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

const handleClickOutside = (event) => {
  // Função para fechar menu mobile quando clicar fora
  if (showMobileMenu.value && !event.target.closest('.menu-lateral') && !event.target.closest('.toggle-btn')) {
    showMobileMenu.value = false
  }
}
</script>

<style scoped>
/* Variáveis */
:root {
  --primary-color: #e2b560;
  --secondary-color: #2c3e50;
  --accent-color: #3498db;
  --text-dark: #333;
  --text-light: #666;
  --bg-light: #f8f9fa;
  --bg-white: #ffffff;
  --shadow: 0 4px 15px rgba(0,0,0,0.1);
  --shadow-hover: 0 8px 25px rgba(0,0,0,0.15);
  --success-color: #27ae60;
  --warning-color: #f39c12;
  --info-color: #3498db;
  --border-radius: 15px;
}

/* Layout Principal */
.dashboard-wrapper {
  display: flex;
  min-height: 100vh;
  background: var(--bg-light);
}

.dashboard-content {
  flex: 1;
  margin-left: 220px;
  padding: 2rem;
  transition: margin-left 0.3s ease;
  min-height: 100vh;
}

/* Header da Dashboard */
.dashboard-header {
  background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
  border-radius: var(--border-radius);
  padding: 2rem;
  margin-bottom: 2rem;
  color: white;
  box-shadow: var(--shadow);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.welcome-section {
  flex: 1;
}

.welcome-title {
  font-size: 2.2rem;
  font-weight: 700;
  margin: 0 0 0.5rem 0;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.welcome-title i {
  font-size: 2rem;
  opacity: 0.9;
}

.welcome-subtitle {
  font-size: 1.1rem;
  margin: 0;
  opacity: 0.95;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.user-level {
  background: rgba(255, 255, 255, 0.2);
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.header-stats .stat-card {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Seção de Estatísticas */
.stats-section {
  margin-bottom: 2rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
}

.stat-card {
  background: var(--bg-white);
  border-radius: var(--border-radius);
  padding: 1.5rem;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.stat-card.large {
  padding: 2rem;
}

.stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: white;
  flex-shrink: 0;
}

.stat-icon.projects {
  background: linear-gradient(45deg, var(--primary-color), #f1c40f);
}

.stat-icon.clients {
  background: linear-gradient(45deg, var(--accent-color), #9b59b6);
}

.stat-icon.revenue {
  background: linear-gradient(45deg, var(--success-color), #2ecc71);
}

.stat-icon.completed {
  background: linear-gradient(45deg, #e74c3c, #c0392b);
}

.stat-content {
  flex: 1;
}

.stat-title {
  font-size: 0.9rem;
  color: var(--text-light);
  margin: 0 0 0.5rem 0;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: var(--text-dark);
  margin: 0 0 0.25rem 0;
}

.stat-description {
  font-size: 0.9rem;
  color: var(--text-light);
  margin: 0;
}

.stat-info {
  text-align: center;
}

.stat-info .stat-number {
  font-size: 1rem;
  font-weight: 600;
}

.stat-info .stat-label {
  font-size: 0.8rem;
  opacity: 0.8;
}

/* Seções */
.section-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--secondary-color);
  margin: 0 0 1.5rem 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.section-title i {
  color: var(--primary-color);
}

/* Ações Rápidas */
.quick-actions-section {
  margin-bottom: 2rem;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.action-card {
  background: var(--bg-white);
  border-radius: var(--border-radius);
  padding: 1.5rem;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 1rem;
  text-decoration: none;
  color: inherit;
  border: 2px solid transparent;
}

.action-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-hover);
  border-color: var(--primary-color);
  color: inherit;
}

.action-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  color: white;
  flex-shrink: 0;
}

.action-content {
  flex: 1;
}

.action-content h4 {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--secondary-color);
  margin: 0 0 0.25rem 0;
}

.action-content p {
  font-size: 0.9rem;
  color: var(--text-light);
  margin: 0;
}

.action-arrow {
  color: var(--text-light);
  font-size: 1.1rem;
  transition: transform 0.3s ease;
}

.action-card:hover .action-arrow {
  transform: translateX(5px);
  color: var(--primary-color);
}

/* Atividades Recentes */
.recent-activity-section {
  margin-bottom: 2rem;
}

.activity-list {
  background: var(--bg-white);
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  overflow: hidden;
}

.activity-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1.5rem;
  border-bottom: 1px solid #f1f1f1;
  transition: background-color 0.3s ease;
}

.activity-item:last-child {
  border-bottom: none;
}

.activity-item:hover {
  background: var(--bg-light);
}

.activity-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  color: white;
  flex-shrink: 0;
}

.activity-icon.success {
  background: var(--success-color);
}

.activity-icon.info {
  background: var(--info-color);
}

.activity-icon.warning {
  background: var(--warning-color);
}

.activity-content {
  flex: 1;
}

.activity-content h5 {
  font-size: 1rem;
  font-weight: 600;
  color: var(--secondary-color);
  margin: 0 0 0.25rem 0;
}

.activity-content p {
  font-size: 0.9rem;
  color: var(--text-light);
  margin: 0 0 0.5rem 0;
}

.activity-time {
  font-size: 0.8rem;
  color: var(--text-light);
  font-style: italic;
}

/* Toggle Button */
.toggle-btn {
  position: fixed;
  top: 15px;
  left: 15px;
  z-index: 1100;
  background: var(--primary-color) !important;
  border: none !important;
  border-radius: 10px !important;
  box-shadow: var(--shadow);
}

/* Responsividade */
@media (max-width: 992px) {
  .dashboard-content {
    margin-left: 0;
    padding: 1.5rem;
  }
  
  .header-content {
    flex-direction: column;
    text-align: center;
  }
  
  .welcome-title {
    font-size: 1.8rem;
  }
  
  .stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  }
  
  .actions-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .dashboard-content {
    padding: 1rem;
  }
  
  .dashboard-header {
    padding: 1.5rem;
  }
  
  .welcome-title {
    font-size: 1.5rem;
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .stat-card {
    padding: 1.5rem;
  }
  
  .activity-item {
    padding: 1rem;
    flex-direction: column;
    text-align: center;
    gap: 0.75rem;
  }
}

@media (max-width: 576px) {
  .dashboard-content {
    padding: 0.75rem;
  }
  
  .dashboard-header {
    padding: 1rem;
  }
  
  .stat-card {
    flex-direction: column;
    text-align: center;
    gap: 0.75rem;
  }
  
  .action-card {
    flex-direction: column;
    text-align: center;
    gap: 0.75rem;
  }
  
  .action-arrow {
    display: none;
  }
}
</style>
