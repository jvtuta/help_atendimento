<template>
  <div class="container">
    <div class="row mb-4">
      <div id="nav_imports">
        <ul class="nav ms-auto border-bottom">
          <li class="nav-item mt-2">
            <a href="" class="nav-link" @click.prevent="imports = true"
              >Importar</a
            >
          </li>
          <li class="nav-item mt-2">
            <a
              href=""
              class="nav-link"
              @click.prevent="(visualizar_imports = true), metas_method()"
              >Visualizar relatórios importados</a
            >
          </li>
        </ul>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-4" v-if="imports">
        <form :action="action" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" :value="csrf_token" />
          <label for="meta" class="form-label">Quadro de vendas</label>
          <div class="form-group">
            <input
              type="file"
              name="meta"
              id="meta"
              class="form-control"
              required
            />
          </div>
          <button class="btn btn-outline-info" type="submit">Importar</button>
        </form>
      </div>
      <div class="col-md-12 " id="tabela_metas" v-if="visualizar_imports">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Colaborador</th>
              <th>Manipulacao</th>
              <th>Revenda</th>
              <th>Vendas ontem</th>
              <th>Vendas total manipulação</th>
            </tr>
          </thead>
          <tbody id="tbody-metas">
            <tr v-for="(meta, index) in metas" :key="meta.id" :id="index">
              <input type="hidden" name="id" :value="meta.id" />
              <td>
                {{meta.nome_usuario}}
              </td>
              <td @dblclick="before_update_meta($event)">
                <input
                  type="text"
                  name="manipulacao"
                  @blur="blur($event)"
                  @keypress="after_update_meta($event)"
                  readonly
                  :placeholder="meta.manipulacao"
                  v-model.lazy="metas[index].manipulacao"
                />
              </td>
              <td @dblclick="before_update_meta($event)">
                <input
                  type="text"
                  name="vendas_ontem"
                  @blur="blur($event)"
                  @keypress="after_update_meta($event)"
                  readonly
                  :placeholder="meta.vendas_ontem"
                  v-model.lazy="metas[index].vendas_ontem"
                />
              </td>
              <td @dblclick="before_update_meta($event)">
                <input
                  type="text"
                  name="vendas_total_manipulacao"
                  @blur="blur($event)"
                  @keypress="after_update_meta($event)"
                  readonly
                  :placeholder="meta.vendas_total_manipulacao"
                  v-model.lazy="metas[index].vendas_total_manipulacao"
                />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["action", "csrf_token"],
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
      imports: false,
      visualizar_imports: false,
      metas: [],
      meta_selecionada: "",
    };
  },
  methods: {
    metas_method() {
      const url = "/api/v1/meta";

      const config = {
        method: "GET",
        url: url,
        headers: { Authorization: "bearer " + this.token },
      };

      axios(config)
        .then((response) => response.data)
        .then((data) => {
          this.metas = data;
        });
    },
    before_update_meta(e) {
      this.meta_selecionada = document.querySelector("tr input").value;
      e.target.removeAttribute("readonly");
      e.target.setAttribute(
        "style",
        "cursor: text !important;font-family: inherit  !important;padding: 0.25em 0.5em  !important;background-color: #fff  !important;border: 2px solid rgb(207, 219, 219)  !important;border-radius: 4px  !important;"
      );
    },
    after_update_meta(e) {
      if (e.key == "Enter") {
        let params = new URLSearchParams();
        params.append(e.target.name, e.target.value);
        params.append("_method", "PATCH");
        const config = {
          method: "POST",
          url: "/api/v1/meta/" + this.meta_selecionada,
          headers: { Authorization: "bearer " + this.token },
          data: params,
        };

        axios(config);
        this.blur(e);
      }
    },
    blur(e) {
      e.target.removeAttribute("style");
    },
    log_method() {
      console.log("log_method");
    },
    log_chat_method() {
      console.log("log_chat_method");
    },
  },
};
</script>

<style>
#nav_imports ul li:hover {
  background-color: rgb(207, 219, 219);
}

#app > main > div > div > div.col-md-2.ps-0.pe-3 > div > nav a:hover
/* #tbody-usuarios tr td input:hover */ {
  background-color: rgb(207, 219, 219);
}

#tabela_metas > table th,
#tabela_metas > table td {
  height: 30px;
  padding: 0px;
  margin: 0px;
  text-align: center;
  font-size: 12px;
}
#tabela_metas > table td {
  cursor: cell;
}

#tbody-metas tr td input {
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