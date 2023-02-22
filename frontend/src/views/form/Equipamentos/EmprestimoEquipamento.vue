<template>
    <v-form @submit.prevent="salvar" >
      <div style="border: 6px solid white; border-radius: 10px; background-color:#E0F2F1; width: auto; padding: 5px;">
      <v-container fluid text-xs-center>
        <v-layout row wrap>
          <v-flex xs12 sm6 md4> 
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
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.EmailSolicitante"
              :counter="30"
              label="Email do solicitante"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm12 md2>
            <v-btn class="primary" style="float:right" type="submit">salvar</v-btn>
          </v-flex>            
        </v-layout>
      </v-container>
    </div>
      </v-form>
    </template>
      
    <script>
    import { vm } from "../../../main";
    export default {
      data: () => ({
        items: [],
        funcionarios: [],
        equipamento: [],
        form:{	
          fk_equipamento: "",		
          Data: "",	
          Devolucao: "",	
          LocalUso: "",	
          EmailSolicitante: "",
          fk_user: vm.$session.get("dados_usuarios").id
        }
      }),
      computed: {
          loadDados() {
          }
      },  
      mounted(){
        this.$http.get("/api/Equipamento").then(({ data }) => (this.equipamento=data)); 
        console.log('vm.$session', vm.$session.get("dados_usuarios"))
        //this.form.fk_user =vm.$session.get("dados_usuarios").id
      },
      methods: {
      limparCampos:function(){
      Object.assign(this.$data.form,this.$options.data().form)
      this.form.errors={};    
      },
        salvar: function() {
              this.$Progress.start();
              this.$http.post("/api/Emprestimo",this.form).then(data => {
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