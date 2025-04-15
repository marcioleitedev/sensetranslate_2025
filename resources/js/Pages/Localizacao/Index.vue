<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <Menu />

  <div class="linha"></div>

  <div class="container mt-5">
    <h1 class="text-center text-warning mb-5">Nossas Localizações</h1>
    <div class="row">
      <div class="col-md-6 mb-4">
        <p class="fw-bold">Rua Fernado Falcão 1219 – Mooca – CEP 03180-003 – São Paulo – SP</p>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.1213807764225!2d-46.591110985022084!3d-23.564083684681517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5eac2f527557%3A0xbd7c36eca1d963c!2sR.%20Fernando%20Falc%C3%A3o%2C%201219%20-%20Mooca%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2003180-003!5e0!3m2!1spt-BR!2sbr!4v1644883041169!5m2!1spt-BR!2sbr"
          width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
      <div class="col-md-6 mb-4">
        <p class="fw-bold">R. Piauí, 210 - sala 74 - Centro - Londrina - CEP: 86020-390</p>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3664.072635610296!2d-51.16106262561716!3d-23.31312325251749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94eb436070790943%3A0x31bdf723a14e16a7!2sR.%20Piau%C3%AD%2C%20210%20-%2074%20-%20Centro%2C%20Londrina%20-%20PR%2C%2086020-390!5e0!3m2!1spt-BR!2sbr!4v1692572267439!5m2!1spt-BR!2sbr"
          width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
</style>
