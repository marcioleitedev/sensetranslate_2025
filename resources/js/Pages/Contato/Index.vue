<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <Menu />

  <div class="linha"></div>

  <div class="container mt-5 mb-5">
    <h1 class="text-center text-warning mb-5">Fale Conosco</h1>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="contact-box p-4 shadow rounded bg-light">
          <p><i class="bi bi-envelope-fill text-primary"></i> <strong>E-mail:</strong> comercial@sensetranslate.com</p>
          <p><i class="bi bi-telephone-fill text-primary"></i> <strong>Fone:</strong> 55 (11) 9 5059-0525</p>

          <hr />

          <h5 class="text-secondary mt-4"><i class="bi bi-share-fill me-2"></i> Redes Sociais</h5>
          <ul class="list-unstyled mt-3">
            <li><i class="bi bi-facebook text-primary me-2"></i> Facebook</li>
            <li><i class="bi bi-instagram text-danger me-2"></i> Instagram</li>
            <li><i class="bi bi-linkedin text-info me-2"></i> Linkedin</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <Footer />
</template>

<script setup>
import Menu from '@/Components/Menu.vue';
import Footer from '@/Components/Footer.vue';
</script>

<style scoped>
.linha {
  border-bottom: 3px solid orange;
  margin-bottom: 30px;
}

.contact-box p,
.contact-box li {
  font-size: 1.1rem;
}

.contact-box ul {
  padding-left: 0;
}
</style>
