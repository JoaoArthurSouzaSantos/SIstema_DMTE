<template>
  <div style="margin-left: 15px;">
    <!-- <v-widget title="Basic Usage"> -->
    <!-- <div slot="widget-content">
        <div class="flexbox-centering">
            <div class="calendario">
            <v-date-picker color="#B0BEC5" v-model="picker"></v-date-picker>
            </div>
            <div class="relogio">
            <relogiodigital></relogiodigital>
            </div>
            <div class="grafico">
              <grafico :dados="receber_valor"></grafico>
            </div>
      </div>
    </div> -->
  <!-- </v-widget> -->
</div>
</template>


<script>
import VWidget from "@/components/VWidget";
import { computed } from 'vue';
export default {
    data() {
        return {
           dados_graficos:[],
        }
    },
    components:{
      relogio,
      grafico,
      relogiodigital,
      VWidget
    },
    created() {
      this.$store.dispatch("getPerfil");
      this.$store.dispatch("getPermissao");
    },
    computed:{
      receber_valor(){
        console.log('receber valor', this.$store.state.conteudo_grafico_emprestimo.ConteudoGraf)
        return this.$store.state.conteudo_grafico_emprestimo.ConteudoGraf
      }
    }
}
</script>



<style>
/* .flexbox-centering{
  width: 100px;
  height: 100px;
  display: inline-block; 
}
 */
.calendario{
  float: left;
}

.relogio{
  float: left;
  margin-left: 200px; 
}

.grafico{
  float: left;
  margin-left: 200px;
}
</style>

<!--  -->