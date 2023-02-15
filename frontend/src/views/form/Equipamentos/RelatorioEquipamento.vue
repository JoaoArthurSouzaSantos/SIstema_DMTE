<template>
    
      <v-container>
        <v-layout row wrap>
          <v-col
            class="d-flex"
            cols="12"
            sm="6"
          >
          <v-flex xs12 sm6 md4> 
            <v-select
            :items="funcionarios"
            label="Selecione o nome funcionario"
            item-text="name"
            item-value="id"
            clearable
            single-line
            @change="busca_epi_funcionario"                             
            ></v-select>                                         
          </v-flex>

          <json-excel :data="funcionarios_EPIS" :name="exportName">
          <v-btn color="success">Exportar <i aria-hidden="true"></i></v-btn>
          </json-excel>

          <v-data-table
                  :headers="complex.headers"
                  :search="search"
                  :items="funcionarios_EPIS"
                  :rows-per-page-items="[10,25,50,{text:'Todos','value':-1}]"
                  rows-per-page-text="Itens por página"
                  no-results-text="Nenhum dado encontrado"
                  no-data-text= "Não há dados disponí­veis"                
                  class="elevation-1"
                  item-key="id"
                  select-all
                  v-model="complex.selected"
                >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.id }}</td>
                    <td>{{ props.item.name }}</td>
                    <td>{{ props.item.nome_epi }}</td>
                    <td class="text-xs-center"></td>
                    <td class="text-xs-center">
                    </td>
                </template>
          </v-data-table>
          </v-col>
        </v-layout>
      </v-container>
    
    </template>
  
  <script>
  import JsonExcel from "vue-json-excel";
  export default {
    data: () => ({
      exportName: "Relatorio_funcionario_epi "+(new Date()).toLocaleString(),
      EPIS: [],
      funcionarios: [],
      funcionarios_EPIS: [],
      search:"",
      complex: {
          selected: [],          
          headers: [
            {
              text: "Nome",
              align: "left",
              value: "name"
            },
            { text: "Marca", value: "nome_epi" },
            { text: "Descricao", value: "fabricante", align: "center" },
            { text: "Ações", value: "action", align: "center" }
          ]
        }      
    }),
    components:{JsonExcel},
    mounted(){
        this.$http.get("/api/funcionario").then( data => {
            this.funcionarios=data.data
            console.log('this.funcionarios',this.funcionarios)
        })
    },
    methods: {
      busca_epi_funcionario: function(id){
          this.$http.get("/api/Relatorio_EPI/"+id).then(data => {
            
            this.funcionarios_EPIS = data.data
            console.log(this.funcionarios_EPIS);
            //this.limparCampos();
            window.getApp.$emit("APP_SAVE");
            //this.$router.push({ path: "/forms/CadastroUsuarios" });
            loader.hide();
          })
          .catch((e) => {
            console.log(e.response);
          });
          //this.$Progress.finish();
      },
    }
  }
  </script>