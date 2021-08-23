<template>
  <div>
    <h5 class="card-title">{{ periodo_dia }}, {{ usuario }}!</h5>
    <div class="row">
      <div class="col-md-4">
          <h4>Suas metas:</h4>
          <ul class="nav flex-column">
              <li class="nav-item" >
                Manipulação:
              </li>
              <li class="nav-item">
                Revenda:

              </li>
              <li class="nav-item">
                Vendas ontem:

              </li>
              <li class="nav-item">
                Realizado manipulação(mês):

              </li>
              <li class="nav-item">
                Realizado vendas(mês):

              </li>
          </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["usuario","data"],
  computed: {
    hora_atual() {
      let hora_atual;
      let date = Date();
      date = date.split(" ");
      hora_atual = date[4];
      hora_atual = hora_atual.split(":");
      return hora_atual[0];
    },
    periodo_dia() {
      let periodo_dia = '';
      if (this.hora_atual < 12) {
        return (periodo_dia = "Bom dia");
      } else if (this.hora_atual < 18) {
        return (periodo_dia = "Boa tarde");
      } else {
        return (periodo_dia = "Boa noite");
      }
    },
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
      metas: [],
    };
  },
  methods: {
    getMeta() {
      const config = {
        method: "GET",
        url: "/api/v1/meta?meta_usuario?data="+this.data,
        headers: { Authorization: "Bearer "+this.token },
      };
      axios(config)
        .then(response=>response.data)
        .then(meta=>this.metas = meta)
    },
  },
  mounted() {
    this.getMeta();
  },
};
</script>

<style>
</style>