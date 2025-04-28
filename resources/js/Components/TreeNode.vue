<template>
  <li>
    <div class="node">
      <p><strong>{{ node.name }}</strong></p>
      <div v-if="node.nato">Nato a {{ node.nato }} em {{ node.il }}</div>
      <div v-if="node.matrimonio">Casado com {{ node.matrimonio }}</div>
      <div v-if="node.smaller">- Minore</div>
    </div>
    <ul v-if="node.children.length">
      <TreeNode v-for="child in node.children" :key="child.id" :node="child" />
    </ul>
  </li>
</template>

<script setup>
defineProps({
  node: {
    type: Object,
    required: true
  }
});

// Importa ele mesmo para ser recursivo
import TreeNode from './TreeNode.vue';
</script>

<style scoped>
.node {
  background: #f9f9f9;
  padding: 10px;
  border-radius: 6px;
  box-shadow: 0px 0px 4px rgba(0,0,0,0.1);
  margin: 5px;
}
</style>
