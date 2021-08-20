<template>
  <div class="container-liquid">
    <div class="row justify-content-center p-5">
      <div class="col-md-2 ps-0 pe-3">
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
            <tbody id="tbody-usuarios">
              <tr
                v-for="(usuario, index) in usuarios"
                :key="usuario.id"
                :id="index"
              >
                <td>
                  <input
                    type="text"
                    name="active"
                    @blur="afterUpdate($event)"
                    readonly
                    :placeholder="usuario.active"
                  />
                </td>
                <td @dblclick="update_user($event)">
                  <input
                    type="text"
                    name="active"
                    @blur="afterUpdate($event)"
                    readonly
                    :placeholder="usuario.administrador"
                    v-model.lazy="usuarios[index].administrador"
                  />
                </td>
                <td >button</td>
                <td @dblclick="update_user($event)">
                  <input
                    type="text"
                    name="active"
                    @blur="afterUpdate($event)"
                    readonly
                    :placeholder="usuario.id_departamento"
                    v-model.lazy="usuarios[index].id_departamento"
                  />
                </td>
                <td @dblclick="update_user($event)">
                  <input
                    type="text"
                    name="active"
                    @blur="afterUpdate($event)"
                    readonly
                    :placeholder="usuario.name"
                    v-model.lazy="usuarios[index].name"
                  />
                </td>
                <td @dblclick="update_user($event)">
                  <input
                    type="text"
                    name="active"
                    @blur="afterUpdate($event)"
                    readonly
                    :placeholder="usuarios.nivel_usuario"
                    v-model.lazy="usuarios[index].nivel_usuario"
                  />
                </td>
                <td @dblclick="update_user($event)">
                  <input
                    type="text"
                    name="active"
                    @blur="afterUpdate($event)"
                    readonly
                    :placeholder="usuario.nome_usuario"
                    v-model.lazy="usuarios[index].nome_usuario"
                  />
                </td>
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
      e.target.removeAttribute("readonly");
      e.target.setAttribute(
        "style",
        "cursor: text !important;font-family: inherit  !important;padding: 0.25em 0.5em  !important;background-color: #fff  !important;border: 2px solid rgb(207, 219, 219)  !important;border-radius: 4px  !important;"
      );
    },
    afterUpdate(e) {
      e.target.removeAttribute("style");
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