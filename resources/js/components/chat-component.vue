<template>
  <div class="container">
    <h2>Chat</h2>
    <hr />
    <!-- Usuários Perfis(ultima mensagem, ativo?, n° mensagens não lidas, foto de perfil e nome) -->
    <div class="row">
      <div
        class="col-md-3 col-sm-12 mb-4 me-1"
        id="chatMessages"
        v-if="chatMessages"
      >
        <div v-for="departamento in departamentos" :key="departamento.id">
          <template v-if="departamento.users.length != 0">
            <div class="mt-3">
              <h5>{{ departamento.nome_departamento }}</h5>
              <hr />
            </div>
          </template>
          <ul class="list-group">
            <li
              class="list-group-item"
              v-for="usuario in departamento.users"
              :key="usuario.id"
            >
              <div class="card" style="max-height: 14rem">
                <div class="row g-0">
                  <!-- <div class="col-md-2 text-center m-auto">
                    <i class="fas fa-user fa-2x"></i>
                  </div> -->
                  <div class="col">
                    <div class="card-body" @click="selectActivePanel(usuario)">
                      <div class="card-title h-5">
                        {{ usuario.name }}
                        <div
                          v-if="usuario.notificacao === true"
                          class="float-end notificacao bg-primary"
                        ></div>
                      </div>

                      <p class="card-text textcard">
                        <!-- {{ usuario.ultima_mensagem.desc_mensagem }} -->
                      </p>
                      <p class="card-text">
                        <small class="text-muted"> </small>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div
        class="mb-2"
        id="button_back"
        v-if="button_back"
        @click="
          () => {
            button_back = false;
            chatMessages = true;
            mensagemContainer = false;
            icone = false;
          }
        "
      >
        <button class="btn btn-outline-primary btn-sm">Voltar</button>
      </div>
      <div
        class="col-md-8 col-sm-12"
        v-if="mensagemContainer"
        id="mensagemContainer"
        @click="focus('desc_mensagem')"
      >
        <div class="card mb-0">
          <div class="row g-0">
            <div class="card-header col-md-12">
              <h5 class="card-title">{{ usuario_destino_nome }}</h5>
            </div>
            <div class="card-body col-md-10 mensagem-container">
              <div v-for="mensagem in mensagens" :key="mensagem.id" class="row">
                <template
                  v-if="mensagem.para_user_id == usuario_autenticado_id_"
                  ><div class="col">
                    <p class="float-start">
                      {{ mensagem.desc_mensagem }}
                      <span
                        class="text-muted d-block"
                        style="font-size: 0.8rem"
                      >
                        {{ mensagem.created_at | formatDate() }}
                      </span>
                      <img
                        v-if="mensagem.urn_arquivo"
                        style="width: 250px; height: 250px"
                        @click="downloadImage(mensagem.urn_arquivo)"
                        :src=" '/storage/'+mensagem.urn_arquivo  "
                      >
                    </p>
                  </div>
                </template>

                <template v-else>
                  <div class="col">
                    <p class="float-end text-dark">
                      {{ mensagem.desc_mensagem }}
                      <span
                        class="text-muted d-block"
                        style="font-size: 0.8rem"
                      >
                        {{ mensagem.created_at | formatDate() }}
                      </span>
                      <img
                        v-if="mensagem.urn_arquivo"
                        style="width: 250px; height: 250px"
                        @click="downloadImage(mensagem.urn_arquivo)"
                        :src=" '/storage/'+mensagem.urn_arquivo  "
                      >
                    </p>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <form method="post" @submit.prevent="sendMessage()">
            <input type="hidden" name="csrf_token" :value="csrf_token" />
            <div class="input-group">
              <input
                type="text"
                name="desc_mensagem"
                id="desc_mensagem"
                class="form-control form-control-sm col-xs-12"
                placeholder="Digite aqui..."
                v-model="desc_mensagem"
              />
              <label class="btn btn-outline-primary p-1 m-0" for="file-image"
                >imagem</label
              >
              <input
                type="file"
                name="imagem"
                class="form-control"
                accept="image/*"
                id="file-image"
                @change="uploadImage($event)"
                placeholder="imagem"
                style="display: none"
              />

              <button class="btn btn-outline-primary p-1">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
export default {
  props: ["csrf_token"],
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
      button_back: false,
      chatMessages: true,
      icone: true,
      desc_mensagem: "",
      usuario_autenticado_id_: "",
      usuario_destino: "",
      usuario_destino_nome: "",
      mensagens: [],
      departamentos: [],
    };
  },
  methods: {
    async usuario_autenticado_id() {
      const url = "/api/v1/usuario?usuario_autenticado=true";
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
      this.usuario_autenticado_id_ = usuario_autenticado_id;
      return usuario_autenticado_id;
    },

    focus(elemento) {
      document.getElementById(elemento).focus();
    },

    scrollToEnd: function (seletor) {
      var container = this.$el.querySelector(seletor);
      container.scrollTop = container.scrollHeight;
    },

    async getUsers() {
      const url = "/api/v1/departamento";
      const config = {
        headers: {
          Authorization: "bearer " + this.token,
        },
      };
      let usuario_autenticado_id = await this.usuario_autenticado_id();
      this.usuario_autenticado_id_ = usuario_autenticado_id;
      await axios
        .get(url, config)
        .then((response) => response.data)
        .then((data) => {         
          data.forEach((departamento) => {
            if (
              departamento.users !== undefined &&
              departamento.users.length != 0
            ) {
              let usuarios = []
              departamento.users.forEach((usuario, index)=> {
                if(usuario.id !== this.usuario_autenticado_id_ && usuario.active === 1) {
                  usuarios.push(usuario);
                  this.usuarios.push(usuario)
                }
              })
              departamento.users = usuarios;
              this.departamentos.push(departamento)
            }
          });
        });

    },

    async selectActivePanel(usuario) {
      this.usuario_destino = usuario.id;
      this.usuario_destino_nome = usuario.name;
      this.mensagemContainer = true;
      this.usuarios.forEach((u, i) => {
        if (this.usuarios[i].notificacao)
          Vue.set(this.usuarios[i], "notificacao", false);
      });
      if (screen.width < 576) {
        this.button_back = true;
        this.chatMessages = false;
      }
      const url =
        "/api/v1/mensagem?getMessages=de_user_id=" +
        this.usuario_autenticado_id_ +
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

      this.scrollToEnd(".mensagem-container");
    },

    uploadImage(event) {
      const url = "/api/v1/mensagem";

      let data = new FormData();
      console.log(event.target.files[0]);
      
      data.append("imagem", event.target.files[0]);
      data.append("de_usuario_id", this.usuario_autenticado_id_);
      data.append("para_usuario_id", this.usuario_destino);

      let config = {
        headers: {
          Authorization: "bearer " + this.token,
          "Content-Type": "image/png",
        },
      };

      axios
        .post(url, data, config)
        .then((response) => response.data)
        .then((mensagem) => {
          this.mensagens.push(mensagem);
        });
    },

    async downloadImage(urn_arquivo) {
      let image
      const url = "/storage/"+urn_arquivo;
      image = await fetch(url)
      image = await image.blob()
      let fileURL = window.URL.createObjectURL(image)
      let fileLink = document.createElement("a");
      fileLink.href = fileURL

      fileLink.setAttribute("download",'teste')
      document.body.appendChild(fileLink)
      fileLink.click();
      document.body.removeChild(fileLink);

    },

    async sendMessage() {
      const url = "/api/v1/mensagem";

      this.mensagens.push({
        de_usuario_id: this.usuario_autenticado_id_,
        para_usuario_id: this.usuario_destino,
        desc_mensagem: this.desc_mensagem,
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString(),
      });

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
      this.desc_mensagem = "";
    },
  },
  async mounted() {
    await this.getUsers();

    Echo.private(`user.${this.usuario_autenticado_id_}`).listen(
      ".SendMessage",
      (mensagem) => {
        if (
          this.usuario_destino &&
          this.usuario_destino == mensagem.mensagem.de_user_id
        ) {
          this.mensagens.push(mensagem.mensagem);
          this.scrollToEnd(".mensagem-container");
        } else {
          this.usuarios.filter((usuario, i) => {
            if (usuario.id === mensagem.mensagem.de_user_id) {
              Vue.set(this.usuarios[i], "notificacao", true);
            }
          });
        }
      }
    );
  },

  updated() {
    if (document.querySelector(".mensagem-container"))
      this.scrollToEnd(".mensagem-container");
  },
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

#mensagemContainer > button {
  border-radius: 0 !important;
}

.mensagem-container {
  min-height: 50%;
  max-height: 480px;
  overflow-y: auto;
}

.notificacao {
  border-radius: 50%;
  display: inline-block;
  height: 10px;
  width: 10px;
}

div img:hover {
  cursor: pointer;
}

#chatMessages div .row .col .card-body:hover {
  background-color: rgb(207, 219, 219);
  /* border-radius: 0 25px 25px 0; */
  cursor: pointer;
  text-decoration-color: white;
  color: white;
}
/* #chatMessages div.card {
  border-radius: 25px !important;
} */
#mensagemContainer {
  border-top-right-radius: 50rem;
  border-bottom-right-radius: 50rem;
}

#chatMessages > div > ul > li {
  border: none;
  margin: 0;
  padding: 0;
}
#chatMessages > div > ul > li > div {
  border-collapse: collapse;
}
</style>