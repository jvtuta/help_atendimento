<template>
  <div>
    <h5 class="card-title">{{ periodo_dia }}, {{ usuario }}!</h5>
    <div class="row">
      <div class="col-md-4" v-if="this.metas.length > 0">
        <h5>Suas metas:</h5>
        <ul class="nav flex-column">
          <li class="nav-item">Manipulação: {{ this.metas.manipulacao }}</li>
          <li class="nav-item">Revenda:{{ this.metas.revenda }}</li>
          <li class="nav-item">Vendas ontem: {{ this.metas.vendas_ontem }}</li>
          <li class="nav-item">
            Realizado manipulação(mês):
            {{ this.metas.vendas_total_manipulacao }}
          </li>
          <li class="nav-item" id="faltam_apenas">
            Faltam:
            {{ this.metas.manipulacao - this.metas.vendas_total_manipulacao }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["usuario",'usuario_id', "data", "funcao"],
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
      let periodo_dia = "";
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
    async getMeta() {
      const config = {
        method: "GET",
        url: "/api/v1/meta?meta_usuario="+this.usuario_id,
        headers: { Authorization: "Bearer " + this.token },
      };
      await axios(config)
        .then((response) => response.data)
        .then((meta) => (this.metas = meta[meta.length - 1]));
    },
    calcMeta() {
      let metaPorcent =
        (this.metas.vendas_total_manipulacao * 100) / this.metas.manipulacao;
      
      let data;
      if (this.data <= 10) {
        data = "inicio";
      } else if (this.data <= 20) {
        data = "metade";
      } else {
        data = "final";
      }
      // Caso a meta seja maior que 40 e a data esteja no inicio então é positivo
      switch (data) {
        case "inicio":
          if (metaPorcent >= 40) {
            document.getElementById("faltam_apenas").className += " positivo";
          } else {
            document.getElementById("faltam_apenas").className += " neutro";
          }
          break;
        case "metade":
          if (metaPorcent >= 70) {
            document.getElementById("faltam_apenas").className += " positivo";
          } else if (metaPorcent >= 50) {
            document.getElementById("faltam_apenas").className += " neutro";
          } else {
            document.getElementById("faltam_apenas").className += " negativo";
          }
          break;
        default:
          if (metaPorcent >= 99) {
            document.getElementById("faltam_apenas").className += " metaconcluida";
          } else if (metaPorcent >= 90) {
            document.getElementById("faltam_apenas").className += " positivo";
          } else if(metaPorcent >=75){
            document.getElementById("faltam_apenas").className += " neutro";
          } else {
            document.getElementById("faltam_apenas").className += " negativo";
          }
          break;
      }
    },
  },
  async mounted() {
    if(this.funcao == 'atendente') {
      await this.getMeta();
      this.calcMeta();
    }
    
  },
};
</script>

<style>
.metaconcluida {
  color: blue;
  font-size: 20px;
}

.positivo {
  color: green;
}
.neutro {
  color: rgb(133, 133, 25);
}
.negativo {
  color: red;
}
</style>