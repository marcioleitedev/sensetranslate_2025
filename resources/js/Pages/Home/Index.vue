<template>
  <div class="page-wrapper">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <Menu /> 

    <!-- Hero Section with Animation -->
    <section class="hero-section">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
              <h1 class="hero-title">{{ currentCitizenshipText }}</h1>
              <p class="hero-subtitle">{{ currentSubtitleText }}</p>
              <p class="hero-languages">{{ currentLanguagesText }}</p>
              <div class="hero-buttons mt-4">
                <a href="/servicos" class="btn btn-primary btn-lg me-3">
                  <i class="bi bi-translate"></i> Nossos Serviços
                </a>
                <a href="/contato" class="btn btn-outline-light btn-lg">
                  <i class="bi bi-chat-dots"></i> Solicitar Orçamento
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  <!-- Welcome Section -->
  <section class="welcome-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="section-title">Bem-vindo à Sense Translate</h2>
          <p class="section-subtitle">Tradução profissional que conecta culturas e negócios</p>
          <div class="divider"></div>
        </div>
      </div>
      
      <div class="row mt-5">
        <div class="col-md-6">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-globe"></i>
            </div>
            <h4>Alcance Global</h4>
            <p>Nosso escritório atende clientes nacionais e internacionais, envolvendo comprometimento e experiência. Contamos com excelentes profissionais preparados com conhecimento técnico.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-shield-check"></i>
            </div>
            <h4>Compromisso e Qualidade</h4>
            <p>A Sense Translate assume a missão de configurar linguisticamente a realidade em diversos idiomas, traduzindo com precisão e responsabilidade no sigilo de informação.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Market Section -->
  <section class="market-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h2 class="section-title">O Mercado Atual</h2>
          <p class="lead">O mercado exige a cada dia mais agilidade de ações e clareza de informações. A competitividade é algo crescente onde só continuam no jogo aqueles que conseguem atender todas as exigências estipuladas.</p>
          <p>A Sense Translate surge para ajudar a sua empresa nesse grande jogo de negócios e auxiliar para que a cada dia ela se torne mais e mais qualificada para continuar nessa competição.</p>
          <div class="stats-grid mt-4">
            <div class="stat-item">
              <span class="stat-number">8</span>
              <span class="stat-label">Idiomas</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">11</span>
              <span class="stat-label">Segmentos</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">100%</span>
              <span class="stat-label">Sigilo</span>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="market-image">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services-section">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <h2 class="section-title">Nossos Serviços</h2>
          <p class="section-subtitle">Soluções completas em tradução e comunicação internacional</p>
          <div class="divider"></div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="service-card">
            <div class="service-icon">
              <i class="bi bi-file-text"></i>
            </div>
            <h4>Tradução</h4>
            <p>Tradução precisa e profissional para documentos técnicos, comerciais e acadêmicos.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="service-card">
            <div class="service-icon">
              <i class="bi bi-printer"></i>
            </div>
            <h4>Editoração</h4>
            <p>Serviços de editoração e formatação para materiais impressos e digitais.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="service-card">
            <div class="service-icon">
              <i class="bi bi-chat-square-text"></i>
            </div>
            <h4>Comunicação</h4>
            <p>Auxiliamos a comunicação da sua empresa com o mercado internacional.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Languages Section -->
  <section class="languages-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <h2 class="section-title">Idiomas e Áreas de Atuação</h2>
          <p class="lead">A Sense Translate dispõe para o mercado Tradução e Versão nos idiomas:</p>
          <div class="language-display">
            <strong class="animated-languages">{{ currentAnimatedLanguages }}</strong>
          </div>
          
          <h4 class="mt-4">Segmentos Atendidos</h4>
          <div class="segments-grid">
            <span class="segment-tag">Acadêmico</span>
            <span class="segment-tag">Automotivo</span>
            <span class="segment-tag">Comercial</span>
            <span class="segment-tag">Energia</span>
            <span class="segment-tag">Engenharia</span>
            <span class="segment-tag">Farmacêutico</span>
            <span class="segment-tag">Financeiro</span>
            <span class="segment-tag">Industrial</span>
            <span class="segment-tag">Químicos</span>
            <span class="segment-tag">Tecnologia</span>
            <span class="segment-tag">Transportes</span>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="languages-visual">
            <i class="bi bi-translate"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mission Vision Values -->
  <section class="mvv-section">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
          <h2 class="section-title">Nossos Pilares</h2>
          <p class="section-subtitle">Os valores que norteiam todas as nossas ações</p>
          <div class="divider"></div>
        </div>
      </div>
      
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="mvv-card mission-card">
            <div class="mvv-icon">
              <i class="bi bi-brightness-high"></i>
            </div>
            <h3>Missão</h3>
            <p>Entender as necessidades de cada cliente para prestar um serviço de qualidade, personalizado com eficiência.</p>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="mvv-card vision-card">
            <div class="mvv-icon">
              <i class="bi bi-eye"></i>
            </div>
            <h3>Visão</h3>
            <p>Atender com qualidade e eficiência para agregar valor a seu negócio, em médio e longo prazo, para alcançar os objetivos e ser mais competitivo.</p>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="mvv-card values-card">
            <div class="mvv-icon">
              <i class="bi bi-hand-thumbs-up"></i>
            </div>
            <h3>Valores</h3>
            <ul class="values-list">
              <li><i class="bi bi-check-circle"></i> Compromisso</li>
              <li><i class="bi bi-check-circle"></i> Qualidade</li>
              <li><i class="bi bi-check-circle"></i> Sigilo</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

    <Footer /> 
  </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Menu from '@/Components/Menu.vue'; 
import Footer from '@/Components/Footer.vue'; 

// Textos para animação de cidadania
const citizenshipTexts = [
  "Cidadania Italiana",
  "Cidadania Portuguesa", 
  "Cidadania Espanhola"
];

// Textos para animação de idiomas no banner
const subtitleTexts = [
  "TRADUÇÃO E VERSÃO NOS IDIOMAS",
  "TRANSLATION AND VERSION IN LANGUAGES",
  "TRADUCCIÓN Y VERSIÓN EN IDIOMAS"
];

// Textos para animação de idiomas na seção
const languagesList = [
  "Português",
  "Inglês", 
  "Espanhol",
  "Italiano",
  "Francês",
  "Alemão",
  "Japonês",
  "Chinês"
];

// Estados reativos
const currentCitizenshipText = ref('');
const currentSubtitleText = ref('');
const currentLanguagesText = ref('');
const currentAnimatedLanguages = ref('');

let citizenshipIndex = 0;
let subtitleIndex = 0;
let languageIndex = 0;
let animationIntervals = [];

// Função para simular digitação
const typeWriter = (text, targetRef, speed = 100) => {
  return new Promise((resolve) => {
    let i = 0;
    targetRef.value = '';
    
    const interval = setInterval(() => {
      if (i < text.length) {
        targetRef.value += text.charAt(i);
        i++;
      } else {
        clearInterval(interval);
        resolve();
      }
    }, speed);
    
    animationIntervals.push(interval);
  });
};

// Função para apagar texto
const eraseText = (targetRef, speed = 50) => {
  return new Promise((resolve) => {
    const text = targetRef.value;
    let i = text.length;
    
    const interval = setInterval(() => {
      if (i > 0) {
        targetRef.value = text.substring(0, i - 1);
        i--;
      } else {
        clearInterval(interval);
        resolve();
      }
    }, speed);
    
    animationIntervals.push(interval);
  });
};

// Animação de cidadania
const animateCitizenship = async () => {
  while (true) {
    const text = citizenshipTexts[citizenshipIndex];
    await typeWriter(text, currentCitizenshipText, 150);
    await new Promise(resolve => setTimeout(resolve, 3000)); // Pausa de 3s
    await eraseText(currentCitizenshipText, 100);
    citizenshipIndex = (citizenshipIndex + 1) % citizenshipTexts.length;
  }
};

// Animação de subtitle
const animateSubtitle = async () => {
  while (true) {
    const text = subtitleTexts[subtitleIndex];
    await typeWriter(text, currentSubtitleText, 100);
    await new Promise(resolve => setTimeout(resolve, 4000)); // Pausa de 4s
    await eraseText(currentSubtitleText, 80);
    subtitleIndex = (subtitleIndex + 1) % subtitleTexts.length;
  }
};

// Animação de idiomas no banner
const animateLanguagesBanner = async () => {
  while (true) {
    for (let i = 0; i < languagesList.length; i++) {
      let text = '';
      for (let j = 0; j <= i; j++) {
        text += languagesList[j];
        if (j < i) text += ', ';
      }
      await typeWriter(text, currentLanguagesText, 200);
      await new Promise(resolve => setTimeout(resolve, 1000));
    }
    await new Promise(resolve => setTimeout(resolve, 2000));
    await eraseText(currentLanguagesText, 100);
  }
};

// Animação de idiomas na seção
const animateLanguagesSection = async () => {
  while (true) {
    const text = languagesList[languageIndex];
    await typeWriter(text, currentAnimatedLanguages, 120);
    await new Promise(resolve => setTimeout(resolve, 2000));
    await eraseText(currentAnimatedLanguages, 80);
    languageIndex = (languageIndex + 1) % languagesList.length;
  }
};

onMounted(() => {
  // Iniciar todas as animações com delays diferentes
  setTimeout(() => animateCitizenship(), 500);
  setTimeout(() => animateSubtitle(), 1500);
  setTimeout(() => animateLanguagesBanner(), 2500);
  setTimeout(() => animateLanguagesSection(), 3500);
});

onUnmounted(() => {
  // Limpar todos os intervalos ao sair da página
  animationIntervals.forEach(interval => clearInterval(interval));
});

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
}

/* Forçar centralização global */
body, html {
  margin: 0 !important;
  padding: 0 !important;
  overflow-x: hidden;
  width: 100%;
  text-align: center;
}

/* Container principal centralizado */
.page-wrapper {
  margin: 0 auto !important;
  padding: 0;
  min-height: 100vh;
  overflow-x: hidden;
  width: 100%;
  max-width: 100vw;
  text-align: left;
}

.page-container {
  margin: 0;
  padding: 0;
  min-height: 100vh;
}

/* Hero Section */
.hero-section {
  position: relative;
  height: 100vh;
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
  background: linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.2));
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
  width: 100%;
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: var(--primary-color);
  text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
  min-height: 4rem;
  position: relative;
}

.hero-title::after {
  content: '|';
  animation: blink 1.2s infinite;
  color: var(--primary-color);
}

.hero-subtitle {
  font-size: 1.4rem;
  margin-bottom: 1rem;
  font-weight: 300;
  min-height: 2rem;
  position: relative;
}

.hero-subtitle::after {
  content: '|';
  animation: blink 1.2s infinite;
  color: white;
}

.hero-languages {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  color: #ecf0f1;
  min-height: 1.5rem;
  position: relative;
}

.hero-languages::after {
  content: '|';
  animation: blink 1.2s infinite;
  color: #ecf0f1;
}

.hero-buttons .btn {
  padding: 15px 30px;
  font-size: 1.1rem;
  border-radius: 50px;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 10px;
}

.btn-primary {
  background: var(--primary-color);
  border: 2px solid var(--primary-color);
  color: white;
}

.btn-primary:hover {
  background: transparent;
  color: var(--primary-color);
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(226, 181, 96, 0.3);
}

.btn-outline-light:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
}

/* Seções gerais */
section {
  padding: 80px 0;
  margin: 0 auto;
  width: 100%;
  max-width: 100vw;
  overflow-x: hidden;
}

section:last-of-type {
  margin: 0 auto;
  padding-bottom: 80px;
}

/* Containers Bootstrap centralizados */
.container {
  margin: 0 auto !important;
  padding-left: 15px !important;
  padding-right: 15px !important;
  max-width: 1200px !important;
  width: 100% !important;
}

.container-fluid {
  margin: 0 auto !important;
  padding-left: 15px !important;
  padding-right: 15px !important;
  width: 100% !important;
}

/* Garantir que rows sejam centralizadas */
.row {
  margin-left: 0 !important;
  margin-right: 0 !important;
}

/* Forçar centralização em todos os elementos principais */
.hero-section,
.welcome-section,
.market-section,
.services-section,
.languages-section,
.mvv-section {
  margin-left: auto !important;
  margin-right: auto !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

/* Evitar qualquer overflow ou desalinhamento */
* {
  max-width: 100% !important;
}

.container-fluid,
.container {
  padding-left: 15px !important;
  padding-right: 15px !important;
}

.section-title {
  font-size: 2.8rem;
  font-weight: 700;
  color: var(--secondary-color);
  margin-bottom: 1rem;
  position: relative;
}

.section-subtitle {
  font-size: 1.2rem;
  color: var(--text-light);
  margin-bottom: 2rem;
}

.divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
  margin: 0 auto 3rem;
  border-radius: 2px;
}

/* Welcome Section */
.welcome-section {
  background: var(--bg-light);
  width: 100%;
  margin: 0 auto;
}

.feature-card {
  padding: 2.5rem;
  background: white;
  border-radius: 15px;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  text-align: center;
  height: 100%;
}

.feature-card:hover {
  transform: translateY(-10px);
  box-shadow: var(--shadow-hover);
}

.feature-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  color: white;
  font-size: 2rem;
}

.feature-card h4 {
  color: var(--secondary-color);
  margin-bottom: 1rem;
  font-weight: 600;
}

/* Market Section */
.market-section {
  background: var(--bg-light);
  width: 100%;
  margin: 0 auto;
  text-align: center;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  margin-top: 2rem;
}

.stat-item {
  text-align: center;
  padding: 1.5rem;
  background: white;
  border-radius: 10px;
  box-shadow: var(--shadow);
}

.stat-number {
  display: block;
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--primary-color);
  margin-bottom: 0.5rem;
}

.stat-label {
  color: var(--text-light);
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.market-image {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15rem;
  color: var(--primary-color);
  opacity: 0.1;
}

/* Services Section */
.services-section {
  background: white;
  width: 100%;
  margin: 0 auto;
}

.service-card {
  background: white;
  padding: 2.5rem;
  border-radius: 15px;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  text-align: center;
  height: 100%;
  border-top: 4px solid var(--primary-color);
}

.service-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.service-icon {
  width: 70px;
  height: 70px;
  background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  color: white;
  font-size: 1.8rem;
}

.service-card h4 {
  color: var(--secondary-color);
  margin-bottom: 1rem;
  font-weight: 600;
}

/* Languages Section */
.languages-section {
  background: var(--bg-light);
  color: var(--text-dark);
  width: 100%;
  margin: 0 auto;
  text-align: center;
}

.languages-section .section-title {
  color: var(--secondary-color);
}

.language-display {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: var(--shadow);
  margin: 2rem 0;
  text-align: center;
  min-height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-left: 4px solid var(--primary-color);
}

.animated-languages {
  font-size: 2rem;
  color: var(--primary-color);
  font-weight: 600;
  position: relative;
  min-width: 200px;
}

.animated-languages::after {
  content: '|';
  animation: blink 1s infinite;
  color: var(--primary-color);
}

.segments-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 1.5rem;
  justify-content: flex-start;
}

.languages-section h4 {
  color: var(--secondary-color);
  font-weight: 600;
  margin-bottom: 1rem;
  font-size: 1.3rem;
}

.languages-section .lead {
  color: var(--text-dark);
  font-size: 1.1rem;
}

.segment-tag {
  background: #555555;
  color: white;
  padding: 10px 18px;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: 600;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  text-shadow: none;
  box-shadow: 0 2px 8px rgba(85, 85, 85, 0.2);
}

.segment-tag:hover {
  background: var(--primary-color);
  color: var(--secondary-color);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(226, 181, 96, 0.3);
  border-color: var(--primary-color);
}

.languages-visual {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12rem;
  color: var(--primary-color);
  opacity: 0.1;
}

/* Mission Vision Values Section */
.mvv-section {
  background: white;
  color: var(--text-dark);
  margin: 0 auto;
  padding: 80px 0;
  width: 100%;
  max-width: 100vw;
  overflow-x: hidden;
  text-align: center;
}

.mvv-section .container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  width: 100%;
}

.mvv-section .section-title {
  color: var(--secondary-color);
  font-weight: 700;
  margin-bottom: 1rem;
}

.mvv-section .section-subtitle {
  color: var(--text-light);
  font-size: 1.1rem;
  margin-bottom: 2rem;
}

.mvv-section .divider {
  width: 60px;
  height: 4px;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
  margin: 0 auto 3rem;
  border-radius: 2px;
}

.mvv-card {
  background: white;
  border: 2px solid #f1f1f1;
  box-shadow: var(--shadow);
  padding: 2.5rem;
  border-radius: 20px;
  text-align: center;
  height: 100%;
  transition: all 0.3s ease;
}

.mvv-card:hover {
  border-color: var(--primary-color);
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.mvv-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 2rem;
  color: white;
}

.mvv-card h3 {
  color: var(--secondary-color);
  margin-bottom: 1rem;
  font-weight: 600;
  font-size: 1.5rem;
}

.mvv-card p {
  color: var(--text-light);
  line-height: 1.6;
  font-size: 1rem;
}

.values-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.values-list li {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-bottom: 10px;
  color: var(--text-light);
  font-size: 1rem;
}

.values-list i {
  color: var(--primary-color);
  font-size: 1.1rem;
}

/* Animações */
@keyframes blink {
  0%, 50% { opacity: 1; }
  51%, 100% { opacity: 0; }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-content {
  animation: fadeInUp 1s ease-out;
}

/* Responsividade */
@media (max-width: 1200px) {
  .hero-title { font-size: 3rem; }
  .section-title { font-size: 2.4rem; }
}

@media (max-width: 992px) {
  .hero-title { font-size: 2.5rem; }
  .hero-subtitle { font-size: 1.2rem; }
  .section-title { font-size: 2rem; }
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .market-image, .languages-visual { font-size: 8rem; }
}

@media (max-width: 768px) {
  section { 
    padding: 60px 0; 
    margin: 0;
  }
  section:last-of-type {
    padding-bottom: 60px;
  }
  .hero-section { height: 80vh; }
  .hero-title { font-size: 2rem; min-height: 3rem; }
  .hero-subtitle { font-size: 1rem; }
  .hero-languages { font-size: 1rem; }
  .hero-buttons .btn { padding: 12px 24px; font-size: 1rem; }
  .stats-grid { grid-template-columns: 1fr; }
  .segments-grid { justify-content: center; }
  .animated-languages { font-size: 1.5rem; min-width: 150px; }
}

@media (max-width: 576px) {
  section {
    padding: 40px 0;
    margin: 0;
  }
  section:last-of-type {
    padding-bottom: 40px;
  }
  .hero-buttons { text-align: center; }
  .hero-buttons .btn { 
    display: block; 
    width: 100%; 
    margin-bottom: 10px; 
  }
  .feature-card, .service-card, .mvv-card { padding: 2rem; }
  .market-image, .languages-visual { font-size: 5rem; }
  
  /* Melhor legibilidade dos segmentos em mobile */
  .segments-grid {
    justify-content: center;
    gap: 8px;
  }
  
  .segment-tag {
    font-size: 0.8rem;
    padding: 8px 14px;
    background: #555555;
    color: white;
    border: none;
  }
  
  .segment-tag:hover {
    background: var(--primary-color);
    color: var(--secondary-color);
  }
}

/* Correção para remover espaços extra */
.container-fluid {
  padding: 0;
  margin: 0;
}

/* Garantir que não há overflow horizontal */
* {
  box-sizing: border-box;
}

html, body {
  overflow-x: hidden;
  margin: 0;
  padding: 0;
}
</style>
