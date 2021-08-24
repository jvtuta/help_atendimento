<template>
  <form :action="action" @submit.prevent="login($event)" method="post">
      <input type="hidden" name="_token" :value="csrf_token">
      <div class="form-group row mb-2">
          <label for="nome_usuario" class="input-text mb-1" >Nome de usuário</label>
          <input type="text" name="nome_usuario" id="nome_usuario" class="form-control" placeholder="Coloque o nome de usuário" v-model="nome_usuario" autofocus>
      </div>
      <div class="form-group row mb-2">
          <label for="password" class="input-text mb-1">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Coloque a sua senha" v-model="password">
      </div>
      <button type="submit" class="btn btn-outline-primary">Logar</button>
      <div v-if="feedback_invalido" class="my-2">
        <span class="text-danger" v-html="erro"></span>
      </div>
  </form>
</template>

<script>
export default {
    props: ['csrf_token','action'],
    computed:{

    },
    data() {
        return {
            'nome_usuario':'',
            'password':'',
            'erro':'Usuário ou senha incorretos',
            feedback_invalido:false
        }
    },
    methods: {
        login(e) {
            const url = '/api/v1/login'
            let params = new URLSearchParams({
                'nome_usuario' : this.nome_usuario,
                'password' : this.password
            })

            const config = {
                method:'POST',
                headers: { 'content-type': 'application/x-www-form-urlencoded' },
                data: params,
            }
            axios(url,config)
                .then(response => {
                    let token = response.data.token
                    
                    if(token) {
                        document.cookie= '_Token='+token+';SameSite=lax'
                        e.target.submit()
                    }

            })
                .catch(()=>this.feedback_invalido = true)
        }
    }
}
</script>

<style>

</style>