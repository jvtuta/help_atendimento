<template>
  <li class="nav-item dropdown">
    <a
      id="navbarDropdown"
      class="nav-link dropdown-toggle"
      href="#"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
      v-pre
    >
      Metas
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
       <a class="dropdown-item" :href="route_import">
            Importar
        </a>
        
       <a class="dropdown-item" :href="route_visualizar_imports">
            Visualizar importações
        </a>

    </div>
  </li>
  <!-- <li class="nav-tem dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
      >Metas</a
    >
    <ul class="dropdown-menu">
      <li>
        <a class="dropdown-item" :href="route_import"
          >Importar</a
        >
      </li>
      <li>
        <a
          class="dropdown-item"
          :href="route_visualizar_imports"
          >Visualizar relatórios importados</a
        >
      </li>
    </ul>
  </li> -->
</template>

<script>
export default {
  props: ["route_visualizar_imports", "route_import"],
};
</script>

<style>
</style>