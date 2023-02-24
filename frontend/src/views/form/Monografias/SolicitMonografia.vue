<template>
  <v-form @submit.prevent="salvar" >
    <v-container fluid text-xs-center>
        <v-layout row wrap>
          <v-flex xs12 sm6 md5> 
              <v-select
              :items="monografias"
              v-model="form.fk_monografias"
              label="Selecione o nome do monografias"
              item-text="name"
              item-value="id"
              clearable
              single-line                              
              ></v-select>                                         
            </v-flex> 
            <v-flex xs12 sm6 md5> 
              <v-select
              :items="Professors"
              v-model="form.fk_Professor"
              label="Selecione o nome Professor"
              item-text="name"
              item-value="id"
              clearable
              single-line                              
              ></v-select>                                         
            </v-flex>
          <v-flex xs12 sm12 md2>
            <v-btn class="primary" style="float:right" type="submit">salvar</v-btn>
          </v-flex>           
        </v-layout>
      </v-container>
  </v-form>
  
  </template>

<script>
export default {
  data: () => ({
    items: [],
    Professor: [],
    monografias: [],
    informacoes: [],
    form:{
      id: "",
      id: "",		
      fk_Professor : "",	
      fk_monografias: "",	
    }
  }),
  computed: {
      loadDados() {
      }
  },  
  mounted(){
    this.$http.get("/api/Professor").then(({ data }) => (this.Professors = data)); 
    this.$http.get("/api/Monografia").then(({ data }) => (this.monografias=data)); 
  },
  methods: {
    limparCampos:function(){
    Object.assign(this.$data.form,this.$options.data().form)
    this.form.errors={};    
    },
    salvar: function() {
          this.$Progress.start();
          this.$http.post("/api/emprestimo_monografias",this.form).then(data => {
              console.log(data);
              this.limparCampos();
              window.getApp.$emit("APP_SAVE");
            })
            .catch((e) => {
              this.form.errors = e.response.data.errors;
              console.log(e.response.data.errors);
            });
          this.$Progress.finish();
        }
  }
}
</script>