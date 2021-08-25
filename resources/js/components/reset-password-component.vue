<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form
          :action="action"
          method="post"
          @submit.prevent="resetPassword($event)"
        >
          <input type="hidden" name="_token" :value="csrf_token" />
          <div class="form-group row mb-2">
            <label for="password" class="form-label">Alterar senha</label>
            <div class="input-group mb-2">
              
              <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="Coloque a sua senha"
                v-model="password"
              />
            </div>
            <label for="password_confirmation" class="form-label"
                >Repetir nova senha</label
              >
            <div class="input-group mb-2">
              
              <input
                type="password"
                name="password"
                id="password_confirmation"
                class="form-control"
                placeholder="Coloque a sua senha"
                v-model="password_confirmation"
              />
            </div>
          </div>
          <button type="submit" class="btn btn-outline-primary">Alterar a senha</button>
          <div v-if="feedback_invalido" class="my-2">
            <span class="text-danger" v-html="erro"></span>
          </div>
          <div v-if="feedback_valido">
              <span class="text-success">Senha alterada com sucesso!</span>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["action", "usuario", 'csrf_token'],
  computed: {
    token() {
      let token = "";
      token = document.cookie.split(";");
      if (!document.cookie.includes("_Token=")) {
        token = null;
        return token;
      }
      token = token.filter((e) => {
        return e.includes("_Token=");
      });

      token = token[0].replace("_Token=", "");
      return token;
    },
  },
  data() {
      return {
          erro: '',
          password: '',
          password_confirmation: '',
          feedback_invalido: false,
          feedback_valido: false
      }
  },
  methods: {
    resetPassword(e) {
        if(this.password !== this.password_confirmation) {
            this.feedback_invalido = true
            console.log(this.password, this.password_confirmation)
            this.erro = 'Senhas diferem uma da outra!'
            return;
        }
        let params = new URLSearchParams()
        params.append('password',this.password_confirmation)
        axios({
            method: 'post',
            url: '/api/v1/reset/'+this.usuario,
            headers: { Authorization: "bearer " + this.token },
            data: params
        }).then(response=>response.data)
          .then(data=>{
            if(data.sucesso) {
                this.feedback_valido = true
                setTimeout(()=>{
                    window.location.href = '/app/home'
                }, 2000)
            }
        }).catch(()=>{
            this.feedback_invalido = true;
            this.erro = 'Erro ao alterar senha, verifique com o administrador do sistema'
        })

    },
  },
};
</script>

<style>
</style>