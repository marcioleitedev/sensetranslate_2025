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
            <div class="col-lg-10 text-center">
              <h1 class="hero-title">Sobre a Sense Translate</h1>
              <p class="hero-subtitle">Excelência em tradução com comprometimento e experiência internacional</p>
              <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-number">8+</span>
                  <span class="stat-label">Idiomas</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">11+</span>
                  <span class="stat-label">Segmentos</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">100%</span>
                  <span class="stat-label">Sigilo</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2 class="section-title">Quem Somos</h2>
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
              <h4>Missão Linguística</h4>
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
            <h2 class="section-title">O Mercado</h2>
            <p class="lead">O mercado exige cada dia mais agilidade de ações e clareza de informações. A competitividade é algo crescente onde só continuam no jogo aqueles que conseguem atender todas as exigências estipuladas.</p>
            <p>A Sense Translate surge para ajudar a sua empresa nesse grande jogo de negócios e auxiliar para que a cada dia ela se torne mais e mais qualificada para continuar nessa competição.</p>
            <div class="market-highlights">
              <div class="highlight-item">
                <i class="bi bi-speedometer2"></i>
                <span>Agilidade</span>
              </div>
              <div class="highlight-item">
                <i class="bi bi-eye"></i>
                <span>Clareza</span>
              </div>
              <div class="highlight-item">
                <i class="bi bi-trophy"></i>
                <span>Competitividade</span>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="market-visual">
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
                <i class="bi bi-translate"></i>
              </div>
              <h4>Tradução</h4>
              <p>Serviços de tradução profissional que auxiliam a comunicação de sua empresa com o mercado internacional.</p>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="service-card">
              <div class="service-icon">
                <i class="bi bi-printer"></i>
              </div>
              <h4>Editoração</h4>
              <p>Serviços de editoração e formatação para materiais impressos e digitais com qualidade profissional.</p>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="service-card">
              <div class="service-icon">
                <i class="bi bi-shield-lock"></i>
              </div>
              <h4>Sigilo</h4>
              <p>A qualidade no serviço e o sigilo na informação são valores que norteiam todas as ações da Sense Translate.</p>
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
            <div class="languages-grid">
              <span class="language-tag">Português</span>
              <span class="language-tag">Inglês</span>
              <span class="language-tag">Espanhol</span>
              <span class="language-tag">Italiano</span>
              <span class="language-tag">Francês</span>
              <span class="language-tag">Alemão</span>
              <span class="language-tag">Japonês</span>
              <span class="language-tag">Chinês</span>
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
import { ref } from 'vue';
import Menu from '@/Components/Menu.vue'; 
import Footer from '@/Components/Footer.vue'; 

const bannerText = {
  title: "Cidadania Italiana, Portuguesa e Espanhola",
  subtitle: "TRADUÇÃO E VERSÃO NOS IDIOMAS",
  languages: "Português, Inglês, Espanhol, Italiano, Francês, Alemão, Japonês e Chinês"
};

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
  height: 70vh;
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
  font-size: 3.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
  font-size: 1.4rem;
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
  font-size: 2.5rem;
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

/* Seções gerais */
section {
  padding: 80px 0;
  margin: 0 auto;
  width: 100%;
  max-width: 100vw;
  overflow-x: hidden;
}

.section-title {
  font-size: 2.8rem;
  font-weight: 700;
  color: var(--secondary-color);
  margin-bottom: 1rem;
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

/* About Section */
.about-section {
  background: var(--bg-light);
}

.feature-card {
  padding: 2.5rem;
  background: white;
  border-radius: 15px;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  text-align: center;
  height: 100%;
  border-top: 4px solid var(--primary-color);
}

.feature-card:hover {
  transform: translateY(-5px);
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
  font-size: 2rem;
  color: white;
}

.feature-card h4 {
  color: var(--secondary-color);
  margin-bottom: 1rem;
  font-weight: 600;
}

/* Market Section */
.market-section {
  background: white;
}

.market-highlights {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
}

.highlight-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--secondary-color);
  font-weight: 600;
}

.highlight-item i {
  color: var(--primary-color);
  font-size: 1.5rem;
}

.market-visual {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15rem;
  color: var(--primary-color);
  opacity: 0.1;
}

/* Services Section */
.services-section {
  background: var(--bg-light);
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

.service-card h4 {
  color: var(--secondary-color);
  margin-bottom: 1rem;
  font-weight: 600;
}

/* Languages Section */
.languages-section {
  background: white;
  color: var(--text-dark);
}

.languages-section .section-title {
  color: var(--secondary-color);
}

.languages-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin: 2rem 0;
}

.language-tag {
  background: var(--primary-color);
  color: white;
  padding: 10px 18px;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(226, 181, 96, 0.2);
}

.language-tag:hover {
  background: var(--secondary-color);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
}

.segments-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  justify-content: flex-start;
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
  background: var(--bg-light);
  color: var(--text-dark);
  margin: 0 auto;
  padding: 80px 0;
  width: 100%;
  max-width: 100vw;
  overflow-x: hidden;
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
  color: var(--text-dark);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  font-size: 1rem;
}

.values-list i {
  color: var(--accent-color);
  margin-right: 12px;
  font-size: 1.1rem;
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
  .hero-stats { gap: 2rem; }
  .market-highlights { flex-direction: column; gap: 1rem; }
  .market-visual, .languages-visual { font-size: 8rem; }
}

@media (max-width: 768px) {
  section { 
    padding: 60px 0; 
    margin: 0;
  }
  .hero-section { height: 60vh; }
  .hero-title { font-size: 2rem; }
  .hero-subtitle { font-size: 1rem; }
  .hero-stats { 
    flex-direction: column; 
    gap: 1rem; 
    text-align: center;
  }
  .languages-grid, .segments-grid { 
    justify-content: center; 
  }
  .mvv-section {
    padding: 60px 0;
  }
}

@media (max-width: 576px) {
  section {
    padding: 40px 0;
    margin: 0;
  }
  .hero-section {
    height: 50vh;
  }
  .hero-title {
    font-size: 1.8rem;
  }
  .container {
    padding-left: 10px !important;
    padding-right: 10px !important;
  }
  .mvv-section {
    padding: 40px 0;
  }
}
</style>
