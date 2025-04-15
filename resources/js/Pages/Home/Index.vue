<template>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
      

  <Menu /> 

  <div className="linha"></div>
<div className="banner"> 
    <div className="banner-text">
      <h2>{{ bannerText.title }}</h2>
      <p>{{ bannerText.subtitle }}</p>
      <p>{{ bannerText.languages }}</p>
    </div>
  </div>
  
  <div className="container text-center">
    <h1 className="mt-5 text-warning">Bem-vindo à Sense Translate</h1>
    
    <section className="intro">
      <p className="lead">
        Nosso escritório atende clientes nacionais e internacionais, envolvendo comprometimento e experiência para com eles.
        Contamos com excelentes profissionais preparados com conhecimento técnico.
      </p>
      <p>
        A Sense Translate assumi a missão de configurar linguisticamente a realidade em diversos idiomas, traduzindo com precisão
        para um novo idioma a informação passada no idioma original com responsabilidade do sigilo de informação.
      </p>
    </section>

    <section className="market">
      <h2>O Mercado</h2>
      <p>
        O mercado exige a cada dia, mais agilidade de ações e clareza de informações. A competitividade é algo crescente onde
        só continuam no jogo aqueles que conseguem atender todas as exigências estipuladas.
      </p>
      <p>
        A Sense Translate surge para ajudar a sua empresa nesse grande jogo de negócios e auxiliar para que a cada dia ela se
        torne mais e mais qualificada para continuar nessa competição.
      </p>
    </section>

    <section className="services">
      <h2>Serviços</h2>
      <p>
        Através de serviços de tradução, editoração e impressão, a Sense Translate auxilia a comunicação de sua empresa com o
        mercado internacional, bem como filiais ou matrizes internacionais da mesma.
      </p>
      <p>
        A qualidade no serviço e o sigilo na informação são valores que norteiam todas as ações da Sense Translate.
      </p>
    </section>

    <section className="languages">
      <h2>Idiomas e Áreas de Atuação</h2>
      <p>
        A Sense Translate dispõe para o mercado Tradução e Versão nos idiomas: <strong>Português, Inglês, Espanhol, Italiano,
        Francês, Alemão, Japonês e Chinês.</strong>
      </p>
      <p>
        A Sense Translate oferece para o mercado serviços de qualidade com profissionais comprometidos com prazo em variados
        segmentos: <strong>Acadêmico; Automotivo; Comercial; Energia; Engenharia; Farmacêutico; Financeiro; Industrial; Químicos;
        Tecnologia; Transportes.</strong>
      </p>
    </section>

    <div className="mission-vision-values">
      <section className="mission">
        <i className="bi bi-brightness-high"></i>
        <h2>Missão</h2>
        <p>Entender as necessidades de cada cliente para prestar um serviço de qualidade, personalizado com eficiência.</p>
      </section>

      <section className="vision">
        <i className="bi bi-eye"></i>
        <h2>Visão</h2>
        <p>
          Atender com qualidade e eficiência para agregar valor a seu negócio, em médio e longo prazo, para alcançar os objetivos e
          ser mais competitivo.
        </p>
      </section>

      <section className="values">
        <i className="bi bi-hand-thumbs-up"></i>
        <h2>Valores</h2>
        <ul>
          <li>Compromisso</li>
          <li>Qualidade</li>
          <li>Sigilo</li>
        </ul>
      </section>
    </div>
  </div>

  <Footer /> 
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

.banner{
    position: relative;
    width: 100%;
    height: 60vh;
    background: url('/images/traducao-home.jpg') no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.banner-text {
    background-color: rgba(0, 0, 0, 0.6);
    padding: 2rem;
    border-radius: 10px;
    color: white;
    max-width: 80%;
}

.banner-text h2 {
    color: orange;
    font-size: 2rem;
    margin-bottom: 1rem;
}

.banner-text p {
    font-size: 1.2rem;
    margin: 0.5rem 0;
}

.boxhome {
  background: rgba(255, 255, 255, 0.85);
  margin-top: 20px;
  border-radius: 15px;
  padding: 30px;
  min-height: 300px;
  box-shadow: 0 0 0.5em black;
}
.linha {
  border-bottom: 3px solid orange;
}

.container {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
}

.text-primary {
  color: #007bff !important;
}

.custom-btn {
  background-color: #28a745;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 5px;
}

.custom-btn:hover {
  background-color: #218838;
}

h1, h2 {
  margin-top: 20px;
  color: #2c3e50;
}

section {
  margin-bottom: 30px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin: 5px 0;
}

/* Alinhamento das seções Missão, Visão, Valores lado a lado */
.mission-vision-values {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
}

.mission, .vision, .values {
  flex: 1;
  margin: 0 10px;
  text-align: center;
}

.mission h2, .vision h2, .values h2 {
  text-align: center;
}

/* Estilo para ícones */
section i {
  font-size: 40px;
  color: #007bff;
  margin-bottom: 10px;
}

section h2 {
  margin-top: 10px;
  font-size: 1.5rem;
  color: #2c3e50;
}
</style>
