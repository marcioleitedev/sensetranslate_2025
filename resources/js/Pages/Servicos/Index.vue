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
              <h1 class="hero-title">Nossos Serviços</h1>
              <p class="hero-subtitle">Soluções completas em tradução e comunicação internacional</p>
              <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-number">9</span>
                  <span class="stat-label">Serviços</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">24/7</span>
                  <span class="stat-label">Suporte</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">100%</span>
                  <span class="stat-label">Qualidade</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-lg-8 text-center">
            <h2 class="section-title">Conheça Nossos Serviços</h2>
            <p class="section-subtitle">Clique em cada serviço para conhecer mais detalhes</p>
            <div class="divider"></div>
          </div>
        </div>

        <div class="row">
          <!-- Tradução Juramentada -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoJuramentada">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingJuramentada">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseJuramentada"
                      aria-expanded="false"
                      aria-controls="collapseJuramentada"
                    >
                      <div class="service-icon">
                        <i class="bi bi-file-earmark-medical-fill"></i>
                      </div>
                      <div class="service-info">
                        <h4>Tradução Juramentada</h4>
                        <span class="service-tag">Documentos Oficiais</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseJuramentada"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingJuramentada"
                    data-bs-parent="#servicoJuramentada"
                  >
                    <div class="accordion-body service-content">
                      <p>Esse tipo de tradução é feito somente por um tradutor Juramentado (Tradutor Público), nomeado e matriculado na Junta Comercial.</p>
                      <p>Os documentos traduzidos por esse profissional são considerados documentos oficiais e têm fé pública, portanto, podem ser usados para fins judiciais e consulares.</p>
                      <p>No Brasil por exemplo, documentos em língua estrangeira necessitam possuir tradução juramentada para ter uma validade legal ou consular.</p>
                      <div class="service-highlight">
                        <strong>Quando usar:</strong> Documentos consulares, documentos pessoais, históricos escolares, diplomas, contratos, etc.
                      </div>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tradução Livre -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoLivre">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingTraducaoLivre">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseTraducaoLivre"
                      aria-expanded="false"
                      aria-controls="collapseTraducaoLivre"
                    >
                      <div class="service-icon">
                        <i class="bi bi-file-earmark-font"></i>
                      </div>
                      <div class="service-info">
                        <h4>Tradução Livre</h4>
                        <span class="service-tag">Textos Gerais</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseTraducaoLivre"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTraducaoLivre"
                    data-bs-parent="#servicoLivre"
                  >
                    <div class="accordion-body service-content">
                      <p>O texto é traduzido ou vertido com precisão das palavras e expressões.</p>
                      <p>Fazemos também um glossário exclusivo por cliente para que a tradução seja exatamente da forma que o mesmo necessita.</p>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tradução Consecutiva -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoConsecutiva">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingTraducaoConsecutiva">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseTraducaoConsecutiva"
                      aria-expanded="false"
                      aria-controls="collapseTraducaoConsecutiva"
                    >
                      <div class="service-icon">
                        <i class="bi bi-people-fill"></i>
                      </div>
                      <div class="service-info">
                        <h4>Tradução Consecutiva</h4>
                        <span class="service-tag">Reuniões</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseTraducaoConsecutiva"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTraducaoConsecutiva"
                    data-bs-parent="#servicoConsecutiva"
                  >
                    <div class="accordion-body service-content">
                      <p>Utilizada em pequenas reuniões ou encontros de negócios com poucas pessoas.</p>
                      <p>O intérprete fica junto aos convidados traduzindo para o idioma dos mesmos.</p>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tradução Simultânea -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoSimultanea">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingTraducaoSimultanea">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseTraducaoSimultanea"
                      aria-expanded="false"
                      aria-controls="collapseTraducaoSimultanea"
                    >
                      <div class="service-icon">
                        <i class="bi bi-headset"></i>
                      </div>
                      <div class="service-info">
                        <h4>Tradução Simultânea</h4>
                        <span class="service-tag">Eventos</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseTraducaoSimultanea"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTraducaoSimultanea"
                    data-bs-parent="#servicoSimultanea"
                  >
                    <div class="accordion-body service-content">
                      <p>Utilizada em convenções, grandes reuniões ou palestras.</p>
                      <p>O intérprete fica dentro de uma cabine anti-ruído onde recebe o som do palestrante e retransmite para a platéia no idioma da mesma.</p>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Revisão Gramatical -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoRevisao">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingRevisaoGramatical">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseRevisaoGramatical"
                      aria-expanded="false"
                      aria-controls="collapseRevisaoGramatical"
                    >
                      <div class="service-icon">
                        <i class="bi bi-search"></i>
                      </div>
                      <div class="service-info">
                        <h4>Revisão Gramatical</h4>
                        <span class="service-tag">Correção</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseRevisaoGramatical"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingRevisaoGramatical"
                    data-bs-parent="#servicoRevisao"
                  >
                    <div class="accordion-body service-content">
                      <p>Para trabalhos corporativos ou acadêmicos.</p>
                      <p>Profissionais linguísticos com experiência em diversas áreas são responsáveis pela correção de termos, palavras e expressões.</p>
                      <p>Sempre obedecendo as regras dos respectivos idiomas e o glossário passado pelo cliente.</p>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Dublagem e Legendagem -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoDublagem">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingDublagemLegendagem">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseDublagemLegendagem"
                      aria-expanded="false"
                      aria-controls="collapseDublagemLegendagem"
                    >
                      <div class="service-icon">
                        <i class="bi bi-mic"></i>
                      </div>
                      <div class="service-info">
                        <h4>Dublagem e Legendagem</h4>
                        <span class="service-tag">Audiovisual</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseDublagemLegendagem"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingDublagemLegendagem"
                    data-bs-parent="#servicoDublagem"
                  >
                    <div class="accordion-body service-content">
                      <p>Serviço prestado nas áreas: artísticas, didáticas ou corporativas, para filmes diversos.</p>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Diagramação e Editoração -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoDiagramacao">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingDiagramacao">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseDiagramacao"
                      aria-expanded="false"
                      aria-controls="collapseDiagramacao"
                    >
                      <div class="service-icon">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                      </div>
                      <div class="service-info">
                        <h4>Diagramação e Editoração</h4>
                        <span class="service-tag">Layout</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseDiagramacao"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingDiagramacao"
                    data-bs-parent="#servicoDiagramacao"
                  >
                    <div class="accordion-body service-content">
                      <p>Através de programas gráficos, nossa equipe desenvolve um trabalho que apresenta o documento, além de traduzido ou vertido, no layout do documento original.</p>
                      <p>Caso o documento ainda não tenha tido um desenvolvimento de layout, este serviço fará o mesmo.</p>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Impressão Gráfica -->
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="service-accordion-wrapper">
              <div class="accordion" id="servicoImpressao">
                <div class="accordion-item service-item">
                  <h2 class="accordion-header" id="headingImpressaoGrafica">
                    <button
                      class="accordion-button collapsed service-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseImpressaoGrafica"
                      aria-expanded="false"
                      aria-controls="collapseImpressaoGrafica"
                    >
                      <div class="service-icon">
                        <i class="bi bi-printer"></i>
                      </div>
                      <div class="service-info">
                        <h4>Impressão Gráfica</h4>
                        <span class="service-tag">Finalização</span>
                      </div>
                    </button>
                  </h2>
                  <div
                    id="collapseImpressaoGrafica"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingImpressaoGrafica"
                    data-bs-parent="#servicoImpressao"
                  >
                    <div class="accordion-body service-content">
                      <p>Oferece comodidade e agilidade para você.</p>
                      <p>Após feita a tradução e editoração, oferecemos serviços de impressão de apostilas, manuais, monografias, trabalho de conclusão de curso, entre outros.</p>
                      <div class="service-cta">
                        <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                          <i class="bi bi-whatsapp"></i> Solicitar Orçamento
                        </a>
                      </div>
                    </div>
                  </div>
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
import Menu from '@/Components/Menu.vue';
import Footer from '@/Components/Footer.vue';
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

/* Services Section */
.services-section {
  padding: 80px 0;
  background: var(--bg-light);
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

/* Service Accordion Styling */
.service-accordion-wrapper {
  margin-bottom: 2rem;
}

.service-item {
  border: none !important;
  border-radius: 15px !important;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  background: white;
}

.service-item:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.service-button {
  background: white !important;
  border: none !important;
  padding: 1.5rem !important;
  display: flex !important;
  align-items: center !important;
  gap: 1rem !important;
  transition: all 0.3s ease !important;
  box-shadow: none !important;
}

.service-button:focus {
  box-shadow: none !important;
}

.service-button:not(.collapsed) {
  background: linear-gradient(135deg, var(--primary-color), var(--accent-color)) !important;
  color: white !important;
}

.service-button:not(.collapsed) .service-icon {
  background: rgba(255, 255, 255, 0.2) !important;
  color: white !important;
}

.service-button:not(.collapsed) .service-tag {
  background: rgba(255, 255, 255, 0.2) !important;
  color: white !important;
}

.service-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: white;
  flex-shrink: 0;
  transition: all 0.3s ease;
}

.service-info {
  flex: 1;
  text-align: left;
}

.service-info h4 {
  color: var(--secondary-color);
  margin: 0 0 0.5rem 0;
  font-weight: 600;
  font-size: 1.3rem;
  transition: color 0.3s ease;
}

.service-tag {
  background: var(--primary-color);
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

.service-content {
  padding: 2rem !important;
  background: white;
  border-top: 1px solid #f1f1f1;
}

.service-content p {
  color: var(--text-light);
  line-height: 1.6;
  margin-bottom: 1rem;
}

.service-highlight {
  background: var(--bg-light);
  padding: 1rem;
  border-radius: 8px;
  margin: 1.5rem 0;
  border-left: 4px solid var(--primary-color);
}

.service-highlight strong {
  color: var(--secondary-color);
}

.service-cta {
  margin-top: 2rem;
  text-align: center;
}

.btn-whatsapp {
  background: #25d366;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 25px;
  font-weight: 600;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-whatsapp:hover {
  background: #128c7e;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
}

.btn-whatsapp i {
  font-size: 1.1rem;
}

/* Accordion Arrow Customization */
.service-button::after {
  content: '\f282' !important;
  font-family: 'bootstrap-icons' !important;
  font-size: 1.2rem;
  color: var(--primary-color);
  transition: all 0.3s ease;
  margin-left: auto;
}

.service-button:not(.collapsed)::after {
  transform: rotate(180deg);
  color: white !important;
}

.service-button.collapsed::after {
  transform: rotate(0deg);
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
}

@media (max-width: 768px) {
  .services-section { 
    padding: 60px 0; 
  }
  .hero-section { height: 60vh; }
  .hero-title { font-size: 2rem; }
  .hero-subtitle { font-size: 1rem; }
  .hero-stats { 
    flex-direction: column; 
    gap: 1rem; 
    text-align: center;
  }
  .service-button {
    padding: 1rem !important;
    flex-direction: column;
    text-align: center;
    gap: 0.5rem !important;
  }
  .service-info h4 {
    font-size: 1.1rem;
  }
  .service-icon {
    width: 50px;
    height: 50px;
    font-size: 1.2rem;
  }
}

@media (max-width: 576px) {
  .services-section {
    padding: 40px 0;
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
  .service-content {
    padding: 1.5rem !important;
  }
}
</style>
