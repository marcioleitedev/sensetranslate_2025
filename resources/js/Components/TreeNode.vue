<template>
  <li>
    <div class="tree">
      <p><strong>{{ node.name }}</strong></p>
      <div v-if="node.nato">Nato a {{ node.nato }} em {{ node.il }}</div>
      <div v-if="node.matrimonio">Casado com {{ node.matrimonio }}</div>
      <div v-if="node.smaller">- Minore</div>

      <!-- Botões de ação -->
      <div class="mt-2">
        <button class="btn btn-sm btn-warning me-1" @click="$emit('edit', node)">
          Editar
        </button>
        <button class="btn btn-sm btn-danger" @click="$emit('delete', node)">
          Deletar
        </button>
      </div>
    </div>

    <!-- Renderiza filhos -->
    <ul v-if="node.children.length">
      <TreeNode 
        v-for="child in node.children" 
        :key="child.id" 
        :node="child" 
        @edit="$emit('edit', $event)"
        @delete="$emit('delete', $event)"
      />
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
.tree {
  border: 2px solid #000;
  padding: 10px;
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  font-size: 10px;
  display: inline-block;
  width: 150px; 
  border-radius: 5px;
  transition: all 0.5s;
  background-color: #fff;
  text-align: center;
}

.tree ul {
  padding-top: 20px;
  position: relative;
  transition: all 0.5s;
}

.patriado {
  background: #fff;
  color: #000;
}

.solicitante {
  background: #ccc;
  color: white;
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
