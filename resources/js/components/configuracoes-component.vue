<template>
  <div class="container">
    <div class="row justify-content-center p-5">
      <!-- <div class="col-md-2 ps-0 pe-3">
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
      </div> -->
      <div class="col" id="container">
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
            <tbody id="tbody-usuarios">
              <tr
                v-for="(usuario, index) in usuarios"
                :key="usuario.id"
                :id="index"
              >
                <input type="hidden" name="id" :value="usuario.id" />
                <td>
                  <input type="text" readonly :placeholder="usuario.active" />
                </td>
                <td @dblclick="before_update_user($event)">
                  <input
                    type="text"
                    name="administrador"
                    @blur="blur($event)"
                    @keypress="after_update_user($event)"
                    readonly
                    :placeholder="usuario.administrador"
                    v-model.lazy="usuarios[index].administrador"
                  />
                </td>
                <td>

                  <button 
                    v-if="usuario.autorizado == false"
                    class="btn btn-sm btn-outline-info"
                    @click="autorizar($event)"
                  >
                    <i class="far fa-check-circle"></i>
                  </button> 
                  <button
                    v-else
                    class="btn btn-sm btn-info"
                  >
                    <i class="far fa-check-circle"></i>
                  </button>
                </td>
                <td @dblclick="before_update_user($event)">
                  <input
                    type="text"
                    name="id_departamento"
                    @blur="blur($event)"
                    @keypress="after_update_user($event)"
                    readonly
                    :placeholder="usuario.id_departamento"
                    v-model.lazy="usuarios[index].id_departamento"
                  />
                </td>
                <td @dblclick="before_update_user($event)">
                  <input
                    type="text"
                    name="name"
                    @blur="blur($event)"
                    @keypress="after_update_user($event)"
                    readonly
                    :placeholder="usuario.name"
                    v-model.lazy="usuarios[index].name"
                  />
                </td>
                <td @dblclick="before_update_user($event)">
                  <input
                    type="text"
                    name="nivel_usuario"
                    @blur="blur($event)"
                    @keypress="after_update_user($event)"
                    readonly
                    :placeholder="usuarios.nivel_usuario"
                    v-model.lazy="usuarios[index].nivel_usuario"
                  />
                </td>
                <td @dblclick="before_update_user($event)">
                  <input
                    type="text"
                    name="nome_usuario"
                    @blur="blur($event)"
                    @keypress="after_update_user($event)"
                    readonly
                    :placeholder="usuario.nome_usuario"
                    v-model.lazy="usuarios[index].nome_usuario"
                  />
                </td>
                <td>
                  <button
                    class="btn btn-sm btn-outline-info"
                    @click="resetPassword($event)"
                  >
                    pass
                  </button>
                </td>
                <td>
                  <button class="btn btn-sm btn-outline-danger" @click="deletar($event)">
                    <i class="far fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="text-info" v-if="senha_resetada">
            Senha alterada com sucesso!
          </div>
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
      usuarios: true,
      logs: false,
      log_chat: false,
      senha_resetada: false,
      usuario_autenticado: "",
      usuario_selecionado: "",
      attr_old: "",
    };
  },

  methods: {
    usuarios_method() {
      const url = "/api/v1/usuario?usuarios";

      const config = {
        method: "GET",
        url: url,
        headers: { Authorization: "bearer " + this.token },
      };

      axios(config)
        .then((response) => response.data)
        .then((data) => {
          this.usuarios = data.usuarios;
          this.usuario_autenticado = data.usuario_autenticado;
          this.attr_old = data.usuarios;
        });
    },
    autorizar(e) {
      let params = new URLSearchParams({
        autorizado: 1,
        '_method': "patch",
      });
      const config = {
        method: "post",
        url: "/api/v1/usuario/" + e.path[2].children[0].value,
        headers: { Authorization: "bearer " + this.token },
        data: params,
      };
      axios(config)
        .then(()=>this.usuarios[e.path[2].id].autorizado = true)

    },
    deletar(e) {
      
      const config = {
        method: "delete",
        url: "/api/v1/usuario/" + e.path[2].children[0].value,
        headers: { Authorization: "bearer " + this.token },
      };
      axios(config)
        .then(()=>{
          this.usuarios.splice(e.path[2].id, 1)
        })
    },
    resetPassword(e) {
      let params = new URLSearchParams({ password: "12345678" });
      const config = {
        method: "post",
        url: "/api/v1/reset/" + e.path[2].children[0].value,
        headers: { Authorization: "bearer " + this.token },
        data: params,
      };
      axios(config);
    },
    before_update_user(e) {
      this.usuario_selecionado = e.path[2].children[0].value;
      if (
        e.target.name == "administrador" &&
        !(this.usuario_autenticado.administrador == true)
      ) {
        return;
      }
      e.target.removeAttribute("readonly");
      e.target.setAttribute(
        "style",
        "cursor: text !important;font-family: inherit  !important;padding: 0.25em 0.5em  !important;background-color: #fff  !important;border: 2px solid rgb(207, 219, 219)  !important;border-radius: 4px  !important;"
      );
    },
    after_update_user(e) {
      if (e.key == "Enter") {
        let params = new URLSearchParams();
        params.append(e.target.name, e.target.value);
        params.append("_method", "PATCH");
        const config = {
          method: "POST",
          url: "/api/v1/usuario/" + this.usuario_selecionado,
          headers: { Authorization: "bearer " + this.token },
          data: params,
        };

        axios(config);
        this.blur(e);
      }
    },
    blur(e) {
      const old = this.attr_old;
      e.target.removeAttribute("style");
      this.usuarios = old;
    },
    log_method() {
      console.log("log_method");
    },
    log_chat_method() {
      console.log("log_chat_method");
    },
  },
  mounted() {
    this.usuarios_method()
  },
};
</script>

<style>
#app > main > div > div > div.col-md-2.ps-0.pe-3 > div > nav a:hover
/* #tbody-usuarios tr td input:hover */ {
  background-color: rgb(207, 219, 219);
}

#tabela_usuarios > table th,
#tabela_usuarios > table td {
  height: 30px;
  padding: 0px;
  margin: 0px;
  text-align: center;
  font-size: 12px;
}
#tabela_usuarios > table td {
  cursor: cell;
}

#tbody-usuarios tr td input {
  padding: 6px;
  height: 100%;
  cursor: inherit;
  background-color: inherit;
  box-shadow: 0px 0px 0px 0px;
  border: 0 none;
  outline: 0;
  text-align: center;
}
</style>