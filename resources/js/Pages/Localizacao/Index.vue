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
              <h1 class="hero-title">Nossas Localizações</h1>
              <p class="hero-subtitle">Estamos presentes em pontos estratégicos para melhor atendê-lo</p>
              <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-number">2</span>
                  <span class="stat-label">Escritórios</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">2</span>
                  <span class="stat-label">Estados</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">100%</span>
                  <span class="stat-label">Acessível</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Locations Section -->
    <section class="locations-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-lg-8 text-center">
            <h2 class="section-title">Onde Estamos</h2>
            <p class="section-subtitle">Nossos escritórios estrategicamente localizados para oferecer o melhor atendimento</p>
            <div class="divider"></div>
          </div>
        </div>

        <div class="row">
          <!-- São Paulo -->
          <div class="col-lg-6 col-md-12 mb-5">
            <div class="location-card">
              <div class="location-header">
                <div class="location-icon">
                  <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div class="location-info">
                  <h3>São Paulo - SP</h3>
                  <span class="location-tag">Matriz</span>
                </div>
              </div>
              
              <div class="location-details">
                <div class="address-item">
                  <i class="bi bi-pin-map"></i>
                  <div>
                    <strong>Endereço:</strong><br>
                    Rua Fernando Falcão, 1219 - Mooca<br>
                    CEP: 03180-003 - São Paulo - SP
                  </div>
                </div>
                
                <div class="contact-info">
                  <div class="contact-item">
                    <i class="bi bi-telephone"></i>
                    <span>(11) 95059-0525</span>
                  </div>
                  <div class="contact-item">
                    <i class="bi bi-envelope"></i>
                    <span>contato@sensetranslate.com.br</span>
                  </div>
                  <div class="contact-item">
                    <i class="bi bi-clock"></i>
                    <span>Seg - Sex: 8h às 18h</span>
                  </div>
                </div>

                <div class="location-actions">
                  <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                    <i class="bi bi-whatsapp"></i> Falar no WhatsApp
                  </a>
                  <a href="https://maps.google.com/?q=Rua+Fernando+Falcão,+1219+-+Mooca,+São+Paulo+-+SP" target="_blank" class="btn btn-directions">
                    <i class="bi bi-map"></i> Como Chegar
                  </a>
                </div>
              </div>

              <div class="map-container">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.1213807764225!2d-46.591110985022084!3d-23.564083684681517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5eac2f527557%3A0xbd7c36eca1d963c!2sR.%20Fernando%20Falc%C3%A3o%2C%201219%20-%20Mooca%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2003180-003!5e0!3m2!1spt-BR!2sbr!4v1644883041169!5m2!1spt-BR!2sbr"
                  width="100%" 
                  height="350" 
                  style="border:0;" 
                  allowfullscreen="" 
                  loading="lazy"
                  class="location-map">
                </iframe>
              </div>
            </div>
          </div>

          <!-- Londrina -->
          <div class="col-lg-6 col-md-12 mb-5">
            <div class="location-card">
              <div class="location-header">
                <div class="location-icon">
                  <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div class="location-info">
                  <h3>Londrina - PR</h3>
                  <span class="location-tag">Filial</span>
                </div>
              </div>
              
              <div class="location-details">
                <div class="address-item">
                  <i class="bi bi-pin-map"></i>
                  <div>
                    <strong>Endereço:</strong><br>
                    R. Piauí, 210 - Sala 74 - Centro<br>
                    CEP: 86020-390 - Londrina - PR
                  </div>
                </div>
                
                <div class="contact-info">
                  <div class="contact-item">
                    <i class="bi bi-telephone"></i>
                    <span>(43) 3025-4567</span>
                  </div>
                  <div class="contact-item">
                    <i class="bi bi-envelope"></i>
                    <span>londrina@sensetranslate.com.br</span>
                  </div>
                  <div class="contact-item">
                    <i class="bi bi-clock"></i>
                    <span>Seg - Sex: 8h às 17h</span>
                  </div>
                </div>

                <div class="location-actions">
                  <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-whatsapp">
                    <i class="bi bi-whatsapp"></i> Falar no WhatsApp
                  </a>
                  <a href="https://maps.google.com/?q=R.+Piauí,+210+-+Centro,+Londrina+-+PR" target="_blank" class="btn btn-directions">
                    <i class="bi bi-map"></i> Como Chegar
                  </a>
                </div>
              </div>

              <div class="map-container">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3664.072635610296!2d-51.16106262561716!3d-23.31312325251749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94eb436070790943%3A0x31bdf723a14e16a7!2sR.%20Piau%C3%AD%2C%20210%20-%2074%20-%20Centro%2C%20Londrina%20-%20PR%2C%2086020-390!5e0!3m2!1spt-BR!2sbr!4v1692572267439!5m2!1spt-BR!2sbr"
                  width="100%" 
                  height="350" 
                  style="border:0;" 
                  allowfullscreen="" 
                  loading="lazy"
                  class="location-map">
                </iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact CTA Section -->
    <section class="contact-cta-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2 class="cta-title">Precisa de Nossos Serviços?</h2>
            <p class="cta-subtitle">Entre em contato conosco e descubra como podemos ajudar sua empresa</p>
            <div class="cta-buttons">
              <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-primary btn-lg">
                <i class="bi bi-whatsapp"></i> Falar no WhatsApp
              </a>
              <a href="/contato" class="btn btn-outline-light btn-lg">
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

/* Locations Section */
.locations-section {
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

/* Location Cards */
.location-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  height: 100%;
}

.location-card:hover {
  transform: translateY(-10px);
  box-shadow: var(--shadow-hover);
}

.location-header {
  background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
  color: white;
  padding: 2rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.location-icon {
  width: 60px;
  height: 60px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  flex-shrink: 0;
}

.location-info h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.5rem;
  font-weight: 700;
}

.location-tag {
  background: rgba(255, 255, 255, 0.2);
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 600;
}

.location-details {
  padding: 2rem;
}

.address-item {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: var(--bg-light);
  border-radius: 10px;
  border-left: 4px solid var(--primary-color);
}

.address-item i {
  color: var(--primary-color);
  font-size: 1.2rem;
  margin-top: 0.2rem;
  flex-shrink: 0;
}

.address-item strong {
  color: var(--secondary-color);
}

.contact-info {
  margin-bottom: 2rem;
}

.contact-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
  color: var(--text-light);
}

.contact-item i {
  color: var(--accent-color);
  font-size: 1.1rem;
  width: 20px;
  flex-shrink: 0;
}

.location-actions {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}

.btn-whatsapp {
  background: #25d366;
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 25px;
  font-weight: 600;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  flex: 1;
  justify-content: center;
  min-width: 150px;
}

.btn-whatsapp:hover {
  background: #128c7e;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
}

.btn-directions {
  background: var(--accent-color);
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 25px;
  font-weight: 600;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  flex: 1;
  justify-content: center;
  min-width: 150px;
}

.btn-directions:hover {
  background: #2980b9;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
}

.map-container {
  border-radius: 0 0 20px 20px;
  overflow: hidden;
}

.location-map {
  filter: grayscale(20%);
  transition: filter 0.3s ease;
}

.location-card:hover .location-map {
  filter: grayscale(0%);
}

/* Contact CTA Section */
.contact-cta-section {
  background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
  color: white;
  padding: 80px 0;
  text-align: center;
}

.cta-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.cta-subtitle {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  opacity: 0.9;
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
  background: transparent;
  color: var(--primary-color);
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(226, 181, 96, 0.3);
}

.btn-outline-light {
  background: transparent;
  border: 2px solid white;
  color: white;
}

.btn-outline-light:hover {
  background: white;
  color: var(--secondary-color);
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
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
  .locations-section, .contact-cta-section { 
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
  .location-header {
    flex-direction: column;
    text-align: center;
    gap: 0.5rem;
  }
  .location-actions {
    flex-direction: column;
  }
  .cta-buttons {
    flex-direction: column;
    align-items: center;
  }
}

@media (max-width: 576px) {
  .locations-section, .contact-cta-section {
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
  .location-details {
    padding: 1.5rem;
  }
  .location-header {
    padding: 1.5rem;
  }
  .cta-buttons .btn {
    min-width: auto;
    width: 100%;
  }
}
</style>
