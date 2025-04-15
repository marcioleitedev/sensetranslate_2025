<template>
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col">
          <h5>Empresa</h5>
          <p>© 2025 SenseTranslate. Todos os direitos reservados.</p>
        </div>
        <div class="col">
          <h5>Links</h5>
          <ul class="footer-links">
            <li><a href="/">Home</a></li>
            <li><a href="/servicos">Serviços</a></li>
            <li><a href="/empresa">Empresa</a></li>
            <li><a href="/contato">Contato</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
// Nada necessário aqui por enquanto
</script>

<style scoped>
.footer {
  background-color: #000; /* fundo preto */
  color: #fff;            /* texto branco */
  padding: 40px 20px;
  height: 300px;
}

.footer a {
  color: #fff;
  text-decoration: none;
}

.footer a:hover {
  text-decoration: underline;
}

.footer h5 {
  margin-bottom: 15px;
}

.footer-links {
  list-style: none;
  padding: 0;
}

.footer-links li {
  margin-bottom: 5px;
}
</style>
