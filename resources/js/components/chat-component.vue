<template>
  <div class="container">
    <h2>Chat</h2>
    <hr />
    <!-- Usuários Perfis(ultima mensagem, ativo?, n° mensagens não lidas, foto de perfil e nome) -->
    <div class="row">
      <div class="col-md-4 col-sm-12" id="chatMessages">
        <div
          class="card mb-2 row"
          style="max-height: 14rem"
          v-for="usuario in usuarios"
          :key="usuario.id"
        >
          <div class="row g-0">
            <div class="col-md-2">
              <i class="fas fa-user"></i>
            </div>
            <div class="col-md-10">
              <div class="card-body" @click="selectActivePanel(usuario)">
                <h5 class="card-title">{{ usuario.name }}</h5>
                <p class="card-text textcard">
                  {{ usuario.ultima_mensagem.desc_mensagem }}
                </p>
                <p class="card-text">
                  <small class="text-muted">Last updated 3 mins ago</small>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container para renderizar a janela de mensagem ativa -->
      <div class="col-md-8 col-sm-12" v-if="mensagemContainer">
        <div class="card mb-0 row ms-2">
          <div class="row g-0">
            <div class="col-md-10">
              <div class="card-body">
                <h5 class="card-title">{{ usuario_destino_nome }}</h5>
                <div
                  v-for="mensagem in mensagens"
                  :key="mensagem.id"
                  class="row"
                >
                  <template
                    v-if="mensagem.para_user_id == usuario_autenticado_id_"
                  ><div class="col">
                    <span class="float-start"
                      >{{ mensagem.desc_mensagem }}</span
                    >
                    </div>
                    
                  </template>
                  
                  <template v-else>
                   <div class="col">
                    <span class="float-end"
                      >{{ mensagem.desc_mensagem }}</span
                    >
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>
        <form method="post" @submit.prevent="sendMessage()">
          <div class="input-group ms-2" id="mensagemContainer">
            <input type="hidden" name="csrf_token" :value="csrf_token" />
            <span class="input-group-text"></span>
            <input
              type="text"
              name="desc_mensagem"
              id="desc_mensagem"
              class="form-control"
              placeholder="   Pressione / para digitar"
              v-model="desc_mensagem"
            />
            <button class="btn btn-outline-primary">Enviar</button>
          </div>
        </form>
      </div>
      <!--  -->
    </div>
  </div>
</template>

<script>
export default {
  props: ["csrf_token", "rotamensagem"],
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
      usuarios: [],
      mensagemContainer: false,
      desc_mensagem: "",
      usuario_autenticado_id_: "",
      usuario_destino: "",
      mensagens: "",
      usuario_destino_nome: "",
    };
  },
  methods: {
    async usuario_autenticado_id() {
      const url =
        "http://127.0.0.1:8000/api/v1/usuario?usuario_autenticado=true";
      const config = {
        headers: {
          Authorization: "bearer " + this.token,
        },
      };
      let usuario_autenticado_id;
      await axios
        .get(url, config)
        .then((response) => response.data)
        .then((data) => data.usuario_autenticado)
        .then((res) => (usuario_autenticado_id = res));
      return usuario_autenticado_id;
    },

    async getUsers() {
      const url = "http://127.0.0.1:8000/api/v1/usuario";
      const config = {
        headers: {
          Authorization: "bearer " + this.token,
        },
      };
      let usuario_autenticado_id = await this.usuario_autenticado_id();
      this.usuario_autenticado_id_ = usuario_autenticado_id
      await axios
        .get(url, config)
        .then((response) => response.data)
        .then((data) => {
          data.forEach((usuario) => {
            if (usuario.id != usuario_autenticado_id) {
              usuario.ultima_mensagem =
                usuario.mensagens.length == 0
                  ? ""
                  : usuario.mensagens[usuario.mensagens.length - 1];

              this.usuarios.push(usuario);
            }
          });
        });
    },

    async selectActivePanel(usuario) {
      this.usuario_destino = usuario.id;
      this.usuario_destino_nome = usuario.name;
      this.mensagemContainer = true;

      const url =
        "http://127.0.0.1:8000/api/v1/mensagem?getMessages=de_user_id=" +
        ( this.usuario_autenticado_id_) +
        ";de_user_id=" +
        usuario.id;

      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "bearer " + this.token,
        },
      };

      await axios
        .get(url, config)
        .then((response) => response.data)
        .then((data) => (this.mensagens = data));
    },

    async sendMessage() {
      const url = "http://127.0.0.1:8000/api/v1/mensagem";

      let params = new URLSearchParams({
        de_usuario_id: this.usuario_autenticado_id_,
        para_usuario_id: this.usuario_destino,
        desc_mensagem: this.desc_mensagem,
      });

      const config = {
        method: "POST",
        headers: {
          Authorization: "bearer " + this.token,

          "content-type": "application/x-www-form-urlencoded",
        },
        data: params,
      };

      axios(url, config).catch((err) => console.log(err));
    },
  },
  beforeMount() {
    this.getUsers();
  },
  mounted() {},
};
</script>

<style>
.textcard {
  white-space: nowrap;
  width: 160px;
  overflow: hidden;
  text-overflow: ellipsis;
}
.textcard:hover {
  width: 300px;
}
#chatMessages div .row .col-md-10 .card-body:hover {
  background-color: rgb(207, 219, 219);
  border-radius: 0 25px 25px 0;
  cursor: pointer;
  text-decoration-color: white;
  color: white;
}
#chatMessages div.card {
  border-radius: 25px !important;
}
#mensagemContainer {
  border-top-right-radius: 50rem;
  border-bottom-right-radius: 50rem;
}
</style>