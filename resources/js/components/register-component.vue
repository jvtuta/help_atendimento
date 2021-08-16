<template>
  <div class="card-body p-4">
    <form :action="action" method="post">
      <input type="hidden" name="_token" :value="csrf_token" />
      <div class="mb-2 row">
        <label for="name" class="col-md-4 col-form-label text-md-right"
          >Nome</label
        >
        <div class="col-md-6 form-group">
          <input
            id="name"
            type="text"
            class="form-control"
            name="name"
            required
            autofocus
            placeholder="Nome"
          />
        </div>
      </div>
      <div class="mb-2 row">
        <label for="nome_usuario" class="col-md-4 col-form-label text-md-right"
          >Login</label
        >

        <div class="col-md-6">
          <input
            id="nome_usuario"
            type="text"
            class="form-control"
            name="nome_usuario"
            required
            placeholder="Nome de Usuário"
          />
        </div>
      </div>
      <div class="mb-2 row">
        <label for="password" class="col-md-4 col-form-label text-md-right"
          >Senha</label
        >

        <div class="col-md-6">
          <input
            id="password"
            type="password"
            class="form-control"
            name="password"
            required
            placeholder="Senha"
          />
        </div>
      </div>

      <div class="mb-2 row">
        <label
          for="password-confirm"
          class="col-md-4 col-form-label text-md-right"
          >Confirmar senha</label
        >

        <div class="col-md-6">
          <input
            id="password-confirm"
            type="password"
            class="form-control"
            name="password_confirmation"
            required
            placeholder="Confirmar Senha"
          />
        </div>
      </div>
      

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
      </div>


    </form>
  </div>
</template>

<script>
export default {
  props: ["action", "csrf_token"],
};
</script>

<style>
</style>