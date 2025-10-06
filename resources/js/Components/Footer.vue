<template>
  <footer class="footer">
    <div class="container">
      <div class="row">
        <!-- Coluna 1: Empresa -->
        <div class="col-md-4">
          <h5>SenseTranslate</h5>
          <p class="mb-3">Tradução profissional em diversos idiomas com qualidade e agilidade.</p>
          <p class="mb-0">© 2025 SenseTranslate. Todos os direitos reservados.</p>
        </div>
        
        <!-- Coluna 2: Links Úteis -->
        <div class="col-md-4">
          <h5>Links Úteis</h5>
          <ul class="footer-links">
            <li>
              <a href="/">
                <i class="fas fa-home"></i>
                <span>Home</span>
              </a>
            </li>
            <li>
              <a href="/servicos">
                <i class="fas fa-language"></i>
                <span>Serviços</span>
              </a>
            </li>
            <li>
              <a href="/empresa">
                <i class="fas fa-info-circle"></i>
                <span>Sobre Nós</span>
              </a>
            </li>
            <li>
              <a href="/contato">
                <i class="fas fa-envelope"></i>
                <span>Contato</span>
              </a>
            </li>
            <li>
              <a href="/login">
                <i class="fas fa-user"></i>
                <span>Área do Cliente</span>
              </a>
            </li>
          </ul>
        </div>
        
        <!-- Coluna 3: Redes Sociais -->
        <div class="col-md-4">
          <h5>Siga-nos</h5>
          <p class="mb-3">Conecte-se conosco nas redes sociais</p>
          <div class="social-links">
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-link">
              <i class="fab fa-facebook-f"></i>
              <span>Facebook</span>
            </a>
            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-link">
              <i class="fab fa-instagram"></i>
              <span>Instagram</span>
            </a>
            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-link">
              <i class="fab fa-linkedin-in"></i>
              <span>LinkedIn</span>
            </a>
            <a href="https://wa.me/5511999999999" target="_blank" rel="noopener noreferrer" class="social-link">
              <i class="fab fa-whatsapp"></i>
              <span>WhatsApp</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
// Importar Font Awesome se não estiver globalmente disponível
import { onMounted } from 'vue'

onMounted(() => {
  // Carregar Font Awesome se necessário
  if (!document.querySelector('link[href*="font-awesome"]')) {
    const link = document.createElement('link')
    link.rel = 'stylesheet'
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
    document.head.appendChild(link)
  }
})
</script>

<style scoped>
.footer {
  background: linear-gradient(to bottom, #000, #a1a1a1ff);
  color: #fff;
  padding: 40px 20px;
  min-height: 300px;
  border-top: 4px solid #e2b560;
  position: relative;
}

.footer h5 {
  color: #e2b560;
  margin-bottom: 20px;
  font-weight: 600;
  font-size: 1.2rem;
}

.footer p {
  line-height: 1.6;
  margin-bottom: 15px;
}

.footer a {
  color: #fff;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer a:hover {
  color: #e2b560;
  text-decoration: none;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 10px;
}

.footer-links a {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 0;
  border-bottom: 1px solid transparent;
  transition: all 0.3s ease;
}

.footer-links a:hover {
  border-bottom-color: #e2b560;
  padding-left: 10px;
}

.footer-links i {
  font-size: 1rem;
  width: 16px;
  text-align: center;
}

.social-links {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.social-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 0;
  transition: all 0.3s ease;
  border-radius: 5px;
}

.social-link:hover {
  background-color: rgba(226, 181, 96, 0.1);
  padding-left: 10px;
}

.social-link i {
  font-size: 1.2rem;
  width: 20px;
  text-align: center;
}

.social-link span {
  font-size: 0.95rem;
}

/* Cores específicas para cada rede social */
.social-link:hover .fa-facebook-f {
  color: #1877f2;
}

.social-link:hover .fa-instagram {
  color: #e4405f;
}

.social-link:hover .fa-linkedin-in {
  color: #0077b5;
}

.social-link:hover .fa-whatsapp {
  color: #25d366;
}

/* Responsividade */
@media (max-width: 768px) {
  .footer {
    padding: 30px 15px;
  }
  
  .row {
    text-align: center;
  }
  
  .social-links {
    align-items: center;
    margin-top: 20px;
  }
  
  .social-link {
    justify-content: center;
  }
}

@media (max-width: 576px) {
  .social-links {
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
  }
  
  .social-link span {
    display: none;
  }
  
  .social-link i {
    font-size: 1.5rem;
  }
  
  .footer-links a {
    justify-content: center;
  }
  
  .footer-links span {
    display: none;
  }
  
  .footer-links i {
    font-size: 1.2rem;
  }
}
</style>
