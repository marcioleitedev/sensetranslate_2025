<template>
  <aside :class="['menu-lateral', { 'collapsed': isCollapsed, 'show': showMobileMenu }]">
    <div class="d-flex justify-content-between align-items-center px-3 py-2">
      <h5 class="text-white m-0" v-if="!isCollapsed">Menu</h5>
      <button
        class="btn btn-sm btn-light"
        @click="toggleCollapse"
      >
        <i class="bi" :class="isCollapsed ? 'bi-arrow-right' : 'bi-arrow-left'"></i>
      </button>
    </div>

    <ul class="nav flex-column px-2">
      <li class="nav-item">
        <a class="nav-link text-white" href="#">
          <i class="bi bi-speedometer2 me-2"></i>
          <span v-if="!isCollapsed">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">
          <i class="bi bi-people me-2"></i>
          <span v-if="!isCollapsed">Usuários</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">
          <i class="bi bi-gear me-2"></i>
          <span v-if="!isCollapsed">Configurações</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">
          <i class="bi bi-box-arrow-right me-2"></i>
          <span v-if="!isCollapsed">Sair</span>
        </a>
      </li>
    </ul>
  </aside>
</template>

<script setup>
import { defineProps, defineEmits, ref, watch, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  showMobileMenu: Boolean
})
const emit = defineEmits(['update:showMobileMenu'])

const isCollapsed = ref(false)

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value
}

// fecha menu no mobile se clicar fora dele
const handleClickOutside = (e) => {
  const menu = document.querySelector('.menu-lateral')
  if (
    props.showMobileMenu &&
    menu &&
    !menu.contains(e.target) &&
    !e.target.closest('.toggle-btn')
  ) {
    emit('update:showMobileMenu', false)
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style>
.menu-lateral {
  width: 220px;
  min-height: 100vh;
  background-color: #1b5a9e;
  position: fixed;
  top: 0;
  left: 0;
  transition: all 0.3s ease;
  z-index: 1000;
}

.menu-lateral.collapsed {
  width: 60px;
}

.menu-lateral .nav-link {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.menu-lateral.collapsed .nav-link {
  text-align: center;
}

.menu-lateral .nav-link span {
  display: inline;
}

.menu-lateral.collapsed .nav-link span {
  display: none;
}

/* MOBILE */
@media (max-width: 700px) {
  .menu-lateral {
    transform: translateX(-100%);
  }

  .menu-lateral.show {
    transform: translateX(0%);
  }

  .menu-lateral.collapsed {
    width: 220px;
  }

  .menu-lateral.collapsed .nav-link span {
    display: inline;
  }
}
</style>
