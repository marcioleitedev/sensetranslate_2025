<template>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <div class="container-fluid">
    <main class="main-content">
      <!-- Fundo do modal (escurecido) -->
      <div v-if="showModal" class="modal-backdrop fade show"></div>

      <!-- Árvore Genealógica -->
      <div class="tree-wrapper">
        <div class="tree">
          <ul>
            <TreeNodeClear v-for="node in nodes" :key="node.id" :node="node" @edit="openEditModal" @delete="deleteMember" />
          </ul>
        </div>
      </div>
    </main>
  </div>
</template>

<style>
body {
  background: #ffffff;
  background-image: url('/images/arvore.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  min-height: 100vh;
}

.container-fluid {
  padding: 0;
  margin: 0;
  width: 100%;
}

.main-content {
  width: 100%;
  padding: 1rem;
  min-height: 100vh;
}

.tree-wrapper {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  padding: 1rem 0;
}

.tree {
  min-width: 100%;
  display: flex;
  justify-content: center;
  padding: 1rem;
}

.tree ul {
  padding-top: 20px;
  position: relative;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1rem;
}

.tree li {
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 1rem;
  min-width: 200px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .main-content {
    padding: 0.5rem;
  }

  .tree li {
    min-width: 150px;
    padding: 0.5rem;
  }
}

@media (max-width: 480px) {
  .tree li {
    min-width: 120px;
    padding: 0.25rem;
  }
}

/* Modal styles */
.modal {
  background: rgba(0, 0, 0, 0.5);
  overflow-y: auto;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #000;
  opacity: 0.5;
  z-index: 1050;
}

.modal-dialog {
  margin: 2rem auto;
  max-width: 95%;
  width: 500px;
}

@media (max-width: 576px) {
  .modal-dialog {
    margin: 1rem auto;
    width: 95%;
  }
}
</style>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import TreeNodeClear from '@/Components/TreeNodeClear.vue';
import MenuLateral from '@/components/MenuLateral.vue';
import { usePage } from '@inertiajs/vue3';

// Date referer
const showMobileMenu = ref(false);
const showModal = ref(false);
const editModal = ref(false); // Modal de edição
const nodes = ref([]);
const service = ref({});
const form = ref({
  name: '',
  origin: '',
  type: 1,
  smaller: 0,
  nato: '',
  il: '',
  matrimonio: ''
});
const genealogy = ref([]);

// Take ID the page
const page = usePage();
const serviceId = page.props.id;

// Carrega a árvore genealógica
async function loadGenealogyTree() {
  try {
    const { data } = await axios.get(`http://127.0.0.1:8000/api/genealogy/tree/${serviceId}`);
    
    service.value = data.service;
    genealogy.value = data.genealogy;
    nodes.value = organizeTree(data.genealogy);
  } catch (error) {
    console.error('Erro ao carregar genealogia:', error);
  }
}

// Organize the genealogy tree
function organizeTree(members) {
  const nameToNode = new Map();

  members.forEach(member => {
    nameToNode.set(member.name.trim(), { ...member, children: [] });
  });

  members.forEach(member => {
    const originName = member.origin?.trim();
    if (originName && nameToNode.has(originName)) {
      const parent = nameToNode.get(originName);
      const child = nameToNode.get(member.name.trim());
      parent.children.push(child);
    }
  });

  return members
    .filter(member => {
      const originName = member.origin?.trim();
      return !originName || !nameToNode.has(originName);
    })
    .map(member => nameToNode.get(member.name.trim()));
}

// Submit new member
async function submitForm() {
  try {
    // Validate required fields based on service type
    if (form.value.type === 2) {
      if (!form.value.nato || !form.value.il || !form.value.matrimonio) {
        alert('Por favor, preencha todos os campos obrigatórios para serviço tipo 2 (Nato, IL e Matrimônio)');
        return;
      }
    }

    const payload = { 
      ...form.value, 
      service: serviceId,
      // Ensure type is set to 2 for new service
      type: form.value.type === 2 ? 2 : 1
    };

    await axios.post('http://127.0.0.1:8000/api/genealogy', payload);

    alert('Membro cadastrado com sucesso!');
    resetForm();
    closeModal();
    await loadGenealogyTree();
  } catch (error) {
    console.error('Erro ao cadastrar:', error);
    alert('Erro ao cadastrar o membro.');
  }
}

// Close the Modal
function closeModal() {
  showModal.value = false;
  editModal.value = false; // Fecha o modal de edição também
}

// Reset the Form
function resetForm() {
  form.value = {
    name: '',
    origin: '',
    type: 1,
    smaller: 0,
    nato: '',
    il: '',
    matrimonio: ''
  };
}

// Opem Edit Modal
function openEditModal(node) {
  form.value = { 
    ...node,
    // Ensure type is properly set when editing
    type: node.type === 2 ? 2 : 1
  };
  editModal.value = true;
  showModal.value = true;
}

// Delete member
async function deleteMember(node) {
  try {
    await axios.delete(`http://127.0.0.1:8000/api/genealogy/${node.id}`);
    alert('Membro deletado com sucesso!');
    await loadGenealogyTree();
  } catch (error) {
    console.error('Erro ao deletar membro:', error);
    alert('Erro ao deletar o membro.');
  }
}

// Load the tree when the component is mounted
onMounted(() => {
  loadGenealogyTree();
});
</script>
