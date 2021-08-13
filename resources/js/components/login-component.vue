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
            'password':''
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
                // url: 'http://127.0.0.1:8000/api/v1/login'
            }
            axios(url,config)
                .then(response => {
                    let token = response.data.token
                    
                    if(token) {
                        document.cookie= '_Token='+token+';SameSite=lax'
                        e.target.submit()
                    }

            })
        }
    }
}
</script>

<style>

</style>