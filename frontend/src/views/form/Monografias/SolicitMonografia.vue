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
              :items="Users"
              v-model="form.fk_User"
              label="Selecione o nome User"
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
    Users: [],
    monografias: [],
    informacoes: [],
    form:{
      id: "",
      id: "",		
      fk_User : "",	
      fk_monografias: "",	
    }
  }),
  computed: {
      loadDados() {
        //console.log('dados '+this.$store.state.fornos.FornoList);
      }
  },  
  mounted(){
    this.$http.get("/api/User").then(({ data }) => (this.Users = data)); 
    this.$http.get("/api/Monografia").then(({ data }) => (this.monografias=data)); 
  },
  methods: {
    limparCampos:function(){
    Object.assign(this.$data.form,this.$options.data().form)
    this.form.errors={};    
    },
    salvar: function() {
          this.$Progress.start();
          //let loader = this.$loading.show(); 
          
          //this.form.post("/api/Acoes").then(data => {
          this.$http.post("/api/emprestimo_monografias",this.form).then(data => {
              console.log(data);
              this.limparCampos();
              window.getApp.$emit("APP_SAVE");
              //this.$store.dispatch("getAtualizaAcoes");
              //this.$store.dispatch("getAcoes");
              loader.hide();
              //this.$router.push({ path: "/forms/CadastroUsuarios" });
            })
            .catch((e) => {
              //loader.hide();
              this.form.errors = e.response.data.errors;
              console.log(e.response.data.errors);
            });
          this.$Progress.finish();
        }
  }
}
</script>