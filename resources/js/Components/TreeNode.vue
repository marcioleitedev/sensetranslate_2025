<template>
  <li>
    <div class="tree">
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

.tree{
            border: 2px solid #000;
            padding: 10px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 12px;
            display: inline-block;
            width: 50 px;
            border-radius: 5px;
            transition: all 0.5s;
    
}
.tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
            font-size:12px;
 
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

        .tree li a {
            border: 2px solid #000;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 8 px;
            display: inline-block;
            width: 100 px;
            border-radius: 5px;
            transition: all 0.5s;
        }

        .tree li a:hover,
        .tree li a:hover+ul li a {
            background: #c8e4f8;
            color: #000;
            border: 3px solid #94a0b4;
        }

        .tree li a:hover+ul li::after,
        .tree li a:hover+ul li::before,
        .tree li a:hover+ul::before,
        .tree li a:hover+ul ul::before {
            border-color: #94a0b4;
        }
</style>
