<template>
  <li v-if="node">
    <!-- Aplica os estilos dinamicamente -->
    <div class="tree" :style="{ fontSize: fontSize + 'px', width: boxWidth + 'px' }">
      <p><strong>{{ node.name }}</strong></p>
      <div v-if="node.nato">Nato a {{ node.nato }} em {{ node.il }}</div>
      <div v-if="node.matrimonio">Casado com {{ node.matrimonio }}</div>
      <div v-if="node.smaller">- Minore</div>
    </div>

    <!-- Renderiza filhos -->
    <ul v-if="node.children && node.children.length">
      <TreeNodeClear 
        v-for="child in node.children" 
        :key="child.id" 
        :node="child" 
        :font-size="fontSize"
        :box-width="boxWidth"
      />
    </ul>
  </li>
</template>

<script setup>
import { defineProps, ref, onMounted } from 'vue';

// Captura os parâmetros da URL diretamente
const urlParams = new URLSearchParams(window.location.search);
const fontSize = ref(urlParams.get('fontSize') ? parseInt(urlParams.get('fontSize')) : 12);
const boxWidth = ref(urlParams.get('boxWidth') ? parseInt(urlParams.get('boxWidth')) : 200);

// Logs para depuração
onMounted(() => {
  console.log('Font Size recebido da URL:', fontSize.value);
  console.log('Box Width recebido da URL:', boxWidth.value);
});

// Define as propriedades recebidas pelo componente
defineProps({
  node: {
    type: Object,
    required: true
  },
  fontSize: {
    type: Number,
    default: 12
  },
  boxWidth: {
    type: Number,
    default: 200
  }
});
</script>

<style scoped>
.tree {
  border: 2px solid #000;
  padding: 10px;
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  display: inline-block;
  border-radius: 5px;
  transition: all 0.5s;
  background-color: #fff;
  text-align: center;
}

.tree ul {
  padding-top: 20px;
}

.tree li {
  float: left;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 5px 0 5px;
  transition: all 0.5s;
}

.tree li::before,
.tree li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 2px solid #000;
  width: 50%;
  height: 20px;
}

.tree li::after {
  right: auto;
  left: 50%;
  border-left: 2px solid #000;
}

.tree li:only-child::after,
.tree li:only-child::before {
  display: none;
}

.tree li:only-child {
  padding-top: 0;
}

.tree li:first-child::before,
.tree li:last-child::after {
  border: 0 none;
}

.tree li:last-child::before {
  border-right: 3px solid #000;
  border-radius: 0 5px 0 0;
}

.tree li:first-child::after {
  border-radius: 5px 0 0 0;
}

.tree ul ul::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 3px solid #000;
  width: 0;
  height: 20px;
}

/* Botões */
button {
  font-size: 10px;
  padding: 3px 6px;
}
</style>