<template>
  <div>
    <h2>Árvore Genealógica</h2>
    <div class="tree">
      <ul>
        <TreeNode v-for="node in nodes" :key="node.id" :node="node" />
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import TreeNode from '@/Components/TreeNode.vue'; 

import { usePage } from '@inertiajs/vue3'; 

const nodes = ref([]);

// Função para organizar a árvore
function organizeTree(genealogy) {
  const nameToNode = new Map();

  // Primeiro, cria um mapa de nome -> node
  genealogy.forEach(member => {
    nameToNode.set(member.name.trim(), { ...member, children: [] });
  });

  // Depois conecta os filhos nos seus pais
  genealogy.forEach(member => {
    const originName = member.origin?.trim();
    if (originName && originName !== 'Selecione a Origem' && nameToNode.has(originName)) {
      const parent = nameToNode.get(originName);
      const child = nameToNode.get(member.name.trim());
      parent.children.push(child);
    }
  });

  // Retorna apenas os nós que são "raiz" (sem pai)
  return genealogy
    .filter(member => {
      const originName = member.origin?.trim();
      return !originName || originName === 'Selecione a Origem' || !nameToNode.has(originName);
    })
    .map(member => nameToNode.get(member.name.trim()));
}

// Função para carregar dados
async function loadGenealogyTree(id) {
  try {
    const { data } = await axios.get(`http://127.0.0.1:8000/api/genealogy/tree/${id}`);
    nodes.value = organizeTree(data.genealogy);
  } catch (error) {
    console.error('Erro ao carregar genealogia:', error);
  }
}

const page = usePage();
const serviceId = page.props.id; 

console.log("Aqui o ID recebido:", serviceId);
onMounted(() => {
  loadGenealogyTree(serviceId);
});
</script>

