<template>
  <div class="container">
    <div class="row mb-4"> 
            <div id="nav_imports">
            <ul class="nav ms-auto border-bottom">
                <li class="nav-item mt-2">
                    <a href="" class="nav-link" @click.prevent="imports = true">Importar</a>
                </li>      
                <li class="nav-item mt-2">
                    <a href="" class="nav-link" @click.prevent="imports = true">Visualizar relatórios importados</a>
                </li>      
            </ul>
            </div>
            
        
    </div>
    <div class="row justify-content-center">
      <div class="col-md-4" v-if="imports">
        <form :action="action" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" :value="csrf_token" />
          <label for="meta" class="form-label">Quadro de vendas</label>
          <div class="form-group">
            <input
              type="file"
              name="meta"
              id="meta"
              class="form-control"
              
              
              required
            />
          </div>
          <button class="btn btn-outline-info" type="submit">Importar</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["action", "csrf_token"],
  computed: {},
  data() {
    return {
        imports: false
    }
  },
  methods: {

  }
};
</script>

<style>
#nav_imports ul li:hover {
    background-color: rgb(207, 219, 219);
}
</style>