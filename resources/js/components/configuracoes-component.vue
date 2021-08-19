<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4 ps-0 pe-3">
        <div class="border rounded border-primary pt-3">
          <h5 class="mb-3 ms-3">Menu</h5>
          <nav class="nav flex-column">
            <a
              href=""
              class="nav-link border-bottom border-primary"
              @click.prevent="usuarios_method()"
              >Usuários</a
            >
            <a
              href=""
              class="nav-link border-bottom border-primary"
              @click.prevent="log_method()"
              >Logs</a
            >
            <a href="" class="nav-link" @click.prevent="log_chat_method()"
              >Log chat</a
            >
          </nav>
        </div>
      </div>
      <div class="col-md-8" id="container">
        <div v-if="usuarios" id="tabela_usuarios" class="p-4">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Online</th>
                <th>Administrador</th>
                <th>Autorizado</th>
                <th>Departamento</th>
                <th>Nome</th>
                <th>Função</th>
                <th>Nome de usuario</th>
                <th>#</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(usuario,index) in usuarios" :key="usuario.id" :id="index">
                <td @dblclick="update_user($event)" >{{usuario.active ? usuario.active : '' }} <input v-if="teste" type='number' name='active' v-model="usuarios[index].active"> </td>
                <td @dblclick="update_user($event)" >{{ usuario.administrador ? usuario.administrador : input[1] }}</td>
                <td @dblclick="update_user($event)" >______</td>
                <td @dblclick="update_user($event)" >{{ usuario.id_departamento ? usuario.id_departamento : input[3] }}</td>
                <td @dblclick="update_user($event)" >{{ usuario.name ? usuario.name : input[4] }}</td>
                <td @dblclick="update_user($event)" >{{ usuario.nivel_usuario ? usuario.nivel_usuario : input[5] }}</td>
                <td @dblclick="update_user($event)" >{{ usuario.nome_usuario ? usuario.nome_usuario : input[6] }}</td>
                <td>
                  <button class="btn btn-sm btn-outline-info">pass</button>
                </td>
                <td>
                  <button class="btn btn-sm btn-outline-danger">X</button>
                </td>
              </tr>
            </tbody>
          </table>
          
        </div>
        <div v-if="logs">logs</div>
        <div v-if="log_chat">log_chat</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [],
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
      usuarios: false,
      logs: false,
      log_chat: false,
      input: [
        ,
      ],
      teste : false
    };
  },

  methods: {
    usuarios_method() {
      console.log("usuarios_method");
      const url = "/api/v1/usuario";

      const config = {
        method: "GET",
        url: url,
        headers: { Authorization: "bearer " + this.token },
      };

      axios(config)
        .then((response) => response.data)
        .then((data) => (this.usuarios = data));
    },
    update_user(e) {
      // id do usuario = e.path[1].id
      let old_active, old_administrador, old_id_departamento, old_name, old_nome_usuario, old_nivel_usuario
      switch (e.target.cellIndex) {
        case 0:
          old_active = this.usuarios[0].active 
          this.usuarios[0].active = false
          this.teste = true;
          break;
      
        default:
          break;
      }
    },
    log_method() {
      console.log("log_method");
    },
    log_chat_method() {
      console.log("log_chat_method");
    },
  },
  mounted() {},
};
</script>

<style>

#app > main > div > div > div.col-md-4.ps-0.pe-3 > div > nav a:hover {
  background-color: rgb(207, 219, 219);
}

#tabela_usuarios > table th,
#tabela_usuarios > table td {
  width: 300px;
  padding: 2px;
  margin: 0px;
  font-size: 12px;
}

</style>