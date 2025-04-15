<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <Menu />

  <div class="linha"></div>

  <div class="container my-5">
    <h1 class="text-center text-warning mb-4">Serviços</h1>

    <div class="row justify-content-center">

      <div class="col-md-6">
        <div class="accordion" id="servicosAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingJuramentada">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseJuramentada"
                aria-expanded="false"
                aria-controls="collapseJuramentada"
              >
              <i class="bi bi-file-earmark-medical-fill"></i>  Tradução Juramentada
              </button>
            </h2>
            <div
              id="collapseJuramentada"
              class="accordion-collapse collapse"
              aria-labelledby="headingJuramentada"
              data-bs-parent="#servicosAccordion"
            >
              <div class="accordion-body">
                <p>Esse tipo de tradução é feito somente por um tradutor Juramentado (Tradutor Público), nomeado e matriculado na Junta Comercial.</p>
                <p>Os documentos traduzidos por esse profissional são considerados documentos oficiais e têm fé pública, portanto, podem ser usados para fins judiciais e consulares.</p>
                <p>No Brasil por exemplo, documentos em língua estrangeira necessitam possuir tradução juramentada para ter uma validade legal ou consular.</p>
                <p><strong>Quando usar:</strong> Documentos consulares, documentos pessoais, históricos escolares, diplomas, contratos, etc.</p>

                <div class="text-end mt-4">
                  <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-success">
                    <i class="bi bi-whatsapp me-1"></i> Fale Conosco
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Outros serviços podem ser adicionados aqui com a mesma estrutura -->

        </div>
      </div>
   


      <div class="col-md-6">
        <div class="accordion" id="servicosAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTraducaoLivre">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseTraducaoLivre"
                aria-expanded="false"
                aria-controls="collapseTraducaoLivre"
              >
               <i class="bi bi-file-earmark-text-fill me-2"></i> Tradução Livre
              </button>
            </h2>
            <div
              id="collapseTraducaoLivre"
              class="accordion-collapse collapse"
              aria-labelledby="headingTraducaoLivre"
              data-bs-parent="#servicosAccordion"
            >
              <div class="accordion-body">
               <p>O texto é traduzido ou vertido com precisão das palavras e expressões.</p>
            <p>Fazemos também um glossário exclusivo por cliente para que a tradução seja exatamente da forma que o mesmo necessita.</p>

                <div class="text-end mt-4">
                  <a href="https://wa.me/5511950590525" target="_blank" class="btn btn-success">
                    <i class="bi bi-whatsapp me-1"></i> Fale Conosco
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Outros serviços podem ser adicionados aqui com a mesma estrutura -->

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
</style>
