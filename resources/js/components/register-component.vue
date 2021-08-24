<template>
  <div class="card-body p-4">
    <form :action="action" method="post" @submit.prevent="registro($event)">
      <input type="hidden" name="_token" :value="csrf_token" />
      <div class="mb-2 row">
        <label for="departamentos" class="col-md-4 col-form-label text-md-right"
          >Selecionar departamento</label
        >
        <div class="col-md-6 form-group">
          <select name="id_departamento" id="departamentos" class="form-select" v-model="departamento">
            <option
              v-for="departamento in departamentos"
              :key="departamento.id"
              :value="departamento.id"
            >
              {{ departamento.nome_departamento }}
            </option>
          </select>
        </div>
      </div>
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
            v-model="nome"
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
            v-model="nome_usuario"
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
            v-model="password"
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
            v-model="password_confirmation"
          />
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </form>
    <div class="row mt-2" v-if="registrado">
      <span class="text-success">Registrado com sucesso!</span>
    </div>
    <div class="row mt-2" v-if="registro_falha">
      <span class="text-danger">Falha ao registrar, verifique os dados informados(senha, nome de usuario)</span>
    </div>
  </div>
</template>

<script>
export default {
  props: ["action", "csrf_token"],
  data: () => {
    return {
      departamentos: [],
      departamento:'',
      nome:'',
      nome_usuario:'',
      password:'',
      password_confirmation: '',
      registrado: false,
      registro_falha: false
    };
  },
  methods: {
    registro(e) {
      this.registrado = false
      const url = "/api/v1/register";
      let params = new URLSearchParams({
        id_departamento: this.departamento,
        name: this.nome,
        nome_usuario: this.nome_usuario,
        password: this.password,
        password_confirmation: this.password_confirmation
      });

      const config = {
        method: "POST",
        headers: { "content-type": "application/x-www-form-urlencoded" },
        data: params,
      };
      axios(url, config).then((response) => {
        let token = response.data.token;
        if (token) {
          document.cookie = "_Token=" + token + ";SameSite=lax";
          this.registrado = true
        }
      }).catch(()=>{
        this.registro_falha = true
      });
    },
  },
  mounted() {
    const url = "/api/v1/departamento";

    axios
      .get(url)
      .then((response) => response.data)
      .then((data) => (this.departamentos = data));
  },
};
</script>

<style>
</style>