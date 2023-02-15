<template>
    <v-form @submit.prevent="salvar" >
      <v-container fluid text-xs-center>
        <v-layout row wrap>
          <v-flex xs12 sm6 md5> 
              <v-select
              :items="equipamento"
              v-model="form.fk_equipamento"
              label="Selecione o nome do equipamento"
              item-text="name"
              item-value="id"
              clearable
              single-line                              
              ></v-select>                                         
            </v-flex>
            <v-flex xs12 sm6 md4> 
            <v-text-field type="datetime-local"
              v-model="form.Data"
              :counter="30"
              label="data da do emprestimo"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
            <v-text-field type="datetime-local"
              v-model="form.Devolucao"
              :counter="30"
              label="data de devolução"
              required
              filled
            ></v-text-field>
          </v-flex> 
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.LocalUso"
              :counter="30"
              label="Local de Uso do equipamento"
              required
              filled
            ></v-text-field>
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
        funcionarios: [],
        equipamento: [],
        form:{
          id: "",		
          fk_equipamento: "",		
          Data: "",	
          Devolucao: "",	
          LocalUso: "",	
          EmailSolicitante: "",
        }
      }),
      computed: {
          loadDados() {
          }
      },  
      mounted(){
        this.$http.get("/api/Equipamento").then(({ data }) => (this.equipamento=data)); 
      },
      methods: {
        salvar: function() {
              this.$Progress.start();
              this.$http.post("/api/solicit_equipamento",this.form).then(data => {
                  this.limparCampos();
                  window.getApp.$emit("APP_SAVE");
                  loader.hide();
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