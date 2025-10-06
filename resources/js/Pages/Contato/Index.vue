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
              <h1 class="hero-title">Fale Conosco</h1>
              <p class="hero-subtitle">Estamos prontos para atender suas necessidades de tradução</p>
              <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-number">24h</span>
                  <span class="stat-label">Resposta</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">100%</span>
                  <span class="stat-label">Qualidade</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">8+</span>
                  <span class="stat-label">Idiomas</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-lg-8 text-center">
            <h2 class="section-title">Entre em Contato</h2>
            <p class="section-subtitle">Escolha a forma mais conveniente para falar conosco</p>
            <div class="divider"></div>
          </div>
        </div>

        <div class="row">
          <!-- Contact Info -->
          <div class="col-lg-6 col-md-12 mb-5">
            <div class="contact-card">
              <div class="contact-header">
                <div class="contact-icon">
                  <i class="bi bi-chat-dots-fill"></i>
                </div>
                <h3>Informações de Contato</h3>
              </div>

              <div class="contact-details">
                <div class="contact-item">
                  <div class="contact-item-icon">
                    <i class="bi bi-envelope-fill"></i>
                  </div>
                  <div class="contact-item-info">
                    <h5>E-mail Principal</h5>
                    <p>comercial@sensetranslate.com</p>
                    <a href="mailto:comercial@sensetranslate.com" class="btn btn-email">
                      <i class="bi bi-envelope"></i> Enviar E-mail
                    </a>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-item-icon">
                    <i class="bi bi-telephone-fill"></i>
                  </div>
                  <div class="contact-item-info">
                    <h5>Telefone / WhatsApp</h5>
                    <p>+55 (11) 9 5059-0525</p>
                    <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                      <i class="bi bi-whatsapp"></i> Falar no WhatsApp
                    </a>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-item-icon">
                    <i class="bi bi-clock-fill"></i>
                  </div>
                  <div class="contact-item-info">
                    <h5>Horário de Atendimento</h5>
                    <p>Segunda a Sexta: 8h às 18h<br>Sábado: 8h às 12h</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Social Media & Quick Actions -->
          <div class="col-lg-6 col-md-12 mb-5">
            <div class="social-card">
              <div class="social-header">
                <div class="social-icon">
                  <i class="bi bi-share-fill"></i>
                </div>
                <h3>Redes Sociais</h3>
              </div>

              <div class="social-details">
                <p class="social-description">
                  Siga-nos nas redes sociais para ficar por dentro das novidades e dicas de tradução!
                </p>

                <div class="social-links">
                  <a href="#" class="social-link facebook" target="_blank">
                    <div class="social-link-icon">
                      <i class="bi bi-facebook"></i>
                    </div>
                    <div class="social-link-info">
                      <h5>Facebook</h5>
                      <p>Curta nossa página</p>
                    </div>
                    <i class="bi bi-arrow-right"></i>
                  </a>

                  <a href="#" class="social-link instagram" target="_blank">
                    <div class="social-link-icon">
                      <i class="bi bi-instagram"></i>
                    </div>
                    <div class="social-link-info">
                      <h5>Instagram</h5>
                      <p>Siga nosso perfil</p>
                    </div>
                    <i class="bi bi-arrow-right"></i>
                  </a>

                  <a href="#" class="social-link linkedin" target="_blank">
                    <div class="social-link-icon">
                      <i class="bi bi-linkedin"></i>
                    </div>
                    <div class="social-link-info">
                      <h5>LinkedIn</h5>
                      <p>Conecte-se conosco</p>
                    </div>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <!-- Quick Contact Actions -->
            <div class="quick-actions-card">
              <h4>Ações Rápidas</h4>
              <div class="quick-actions">
                <a href="/servicos" class="quick-action-btn">
                  <i class="bi bi-list-ul"></i>
                  <span>Ver Serviços</span>
                </a>
                <a href="/localizacao" class="quick-action-btn">
                  <i class="bi bi-geo-alt"></i>
                  <span>Localização</span>
                </a>
                <a href="/empresa" class="quick-action-btn">
                  <i class="bi bi-building"></i>
                  <span>Sobre Nós</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2 class="cta-title">Precisa de uma Tradução?</h2>
            <p class="cta-subtitle">Entre em contato agora mesmo e receba um orçamento personalizado</p>
            <div class="cta-buttons">
              <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-primary btn-lg">
                <i class="bi bi-whatsapp"></i> WhatsApp Agora
              </a>
              <a href="mailto:comercial@sensetranslate.com" class="btn btn-outline-light btn-lg">
                <i class="bi bi-envelope"></i> Enviar E-mail
              </a>
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

/* Contact Section */
.contact-section {
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

/* Contact Card */
.contact-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  height: 100%;
}

.contact-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.contact-header {
  background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
  color: white;
  padding: 2rem;
  text-align: center;
}

.contact-icon {
  width: 80px;
  height: 80px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  margin: 0 auto 1rem;
}

.contact-header h3 {
  margin: 0;
  font-size: 1.8rem;
  font-weight: 700;
}

.contact-details {
  padding: 2rem;
}

.contact-item {
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: var(--bg-light);
  border-radius: 15px;
  transition: all 0.3s ease;
}

.contact-item:hover {
  background: #e9ecef;
  transform: translateX(5px);
}

.contact-item-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.2rem;
  flex-shrink: 0;
}

.contact-item-info h5 {
  color: var(--secondary-color);
  margin: 0 0 0.5rem 0;
  font-weight: 600;
}

.contact-item-info p {
  color: var(--text-light);
  margin: 0 0 1rem 0;
  line-height: 1.5;
}

.btn-email, .btn-whatsapp {
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.3s ease;
}

.btn-email {
  background: var(--accent-color);
  color: white;
}

.btn-email:hover {
  background: #2980b9;
  color: white;
  transform: translateY(-2px);
}

.btn-whatsapp {
  background: #25d366;
  color: white;
}

.btn-whatsapp:hover {
  background: #128c7e;
  color: white;
  transform: translateY(-2px);
}

/* Social Card */
.social-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  margin-bottom: 2rem;
}

.social-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.social-header {
  background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
  color: white;
  padding: 2rem;
  text-align: center;
}

.social-icon {
  width: 80px;
  height: 80px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  margin: 0 auto 1rem;
}

.social-header h3 {
  margin: 0;
  font-size: 1.8rem;
  font-weight: 700;
}

.social-details {
  padding: 2rem;
}

.social-description {
  color: var(--text-light);
  margin-bottom: 2rem;
  text-align: center;
}

.social-links {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.social-link {
  display: flex;
  align-items: center;
  padding: 1rem;
  border-radius: 15px;
  text-decoration: none;
  transition: all 0.3s ease;
  border: 2px solid #f1f1f1;
}

.social-link:hover {
  transform: translateX(5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.social-link.facebook {
  border-color: #1877f2;
}

.social-link.facebook:hover {
  background: #f0f8ff;
}

.social-link.instagram {
  border-color: #e4405f;
}

.social-link.instagram:hover {
  background: #fdf2f8;
}

.social-link.linkedin {
  border-color: #0077b5;
}

.social-link.linkedin:hover {
  background: #f0f9ff;
}

.social-link-icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  margin-right: 1rem;
  color: white;
}

.facebook .social-link-icon {
  background: #1877f2;
}

.instagram .social-link-icon {
  background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}

.linkedin .social-link-icon {
  background: #0077b5;
}

.social-link-info {
  flex: 1;
}

.social-link-info h5 {
  margin: 0 0 0.25rem 0;
  color: var(--secondary-color);
  font-weight: 600;
}

.social-link-info p {
  margin: 0;
  color: var(--text-light);
  font-size: 0.9rem;
}

.social-link i:last-child {
  color: var(--text-light);
  font-size: 1.2rem;
}

/* Quick Actions Card */
.quick-actions-card {
  background: white;
  border-radius: 20px;
  padding: 2rem;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
}

.quick-actions-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.quick-actions-card h4 {
  color: var(--secondary-color);
  margin-bottom: 1.5rem;
  text-align: center;
  font-weight: 700;
}

.quick-actions {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 1rem;
}

.quick-action-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1.5rem 1rem;
  background: var(--bg-light);
  border-radius: 15px;
  text-decoration: none;
  color: var(--secondary-color);
  transition: all 0.3s ease;
  text-align: center;
}

.quick-action-btn:hover {
  background: var(--primary-color);
  color: white;
  transform: translateY(-3px);
}

.quick-action-btn i {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.quick-action-btn span {
  font-size: 0.9rem;
  font-weight: 600;
}

/* CTA Section */
.cta-section {
  background: var(--bg-light);
  color: var(--text-dark);
  padding: 80px 0;
  text-align: center;
}

.cta-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
  color: var(--secondary-color);
}

.cta-subtitle {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  color: var(--text-light);
}

.cta-buttons {
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.cta-buttons .btn {
  padding: 15px 30px;
  font-size: 1.1rem;
  border-radius: 50px;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  min-width: 200px;
  justify-content: center;
}

.btn-primary {
  background: var(--primary-color);
  border: 2px solid var(--primary-color);
  color: white;
}

.btn-primary:hover {
  background: var(--secondary-color);
  border-color: var(--secondary-color);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(44, 62, 80, 0.3);
}

.btn-outline-light {
  background: transparent;
  border: 2px solid var(--secondary-color);
  color: var(--secondary-color);
}

.btn-outline-light:hover {
  background: var(--secondary-color);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(44, 62, 80, 0.3);
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
  .cta-title { font-size: 2rem; }
}

@media (max-width: 768px) {
  .contact-section, .cta-section { 
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
  .contact-item {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }
  .social-link {
    flex-direction: column;
    text-align: center;
    gap: 0.5rem;
  }
  .quick-actions {
    grid-template-columns: 1fr;
  }
  .cta-buttons {
    flex-direction: column;
    align-items: center;
  }
}

@media (max-width: 576px) {
  .contact-section, .cta-section {
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
  .contact-details, .social-details {
    padding: 1.5rem;
  }
  .contact-header, .social-header {
    padding: 1.5rem;
  }
  .cta-buttons .btn {
    min-width: auto;
    width: 100%;
  }
}
</style>
