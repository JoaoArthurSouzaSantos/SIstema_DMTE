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
          :items="Users"
          label="Selecione o nome User"
          item-text="name"
          item-value="id"
          clearable
          single-line
          @change="busca_Monografia_User"                             
          ></v-select>                                         
        </v-flex>

        <json-excel :data="Users_Monografias" :name="exportName">
          <v-btn color="success">Exportar <i aria-hidden="true"></i></v-btn>
        </json-excel>

        <v-data-table
                :headers="complex.headers"
                :search="search"
                :items="Users_Monografias"
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
                  <td>{{ props.item.nome_Monografia }}</td>
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
    exportName: "Relatorio_User_Monografia "+(new Date()).toLocaleString(),
    Monografias: [],
    Users: [],
    Users_Monografias: [],
    search:"",
    complex: {
        selected: [],          
        headers: [
          {
            text: "Nome",
            align: "left",
            value: "name"
          },
          { text: "Marca", value: "nome_Monografia" },
          { text: "Ações", value: "action", align: "center" },
        ]
      }      
  }),
  components:{JsonExcel},

  mounted(){
      this.$http.get("/api/User").then( data => {
          this.Users=data.data
          console.log('this.Users',this.Users)
      })
  },
  methods: {
    excluir: function (id) {
        var _this = this;
        MessageBox({
          title: "Responda",
          message: "Deseja excluir o registro?",
          type: "Danger",
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
          showCancelButton: true
        }).then(function(action) {
            _this.$http.delete("/api/Monografia/"+id)
              .then(data => {
                _this.carrega()
                window.getApp.$emit("APP_DELETE");
                _this.$store.state.users.UserList.data
              })
              .catch(() => {});          
        });
      },
      limparCampos:function(){
        this.basic.dialog = false;
        this.form.reset();
        this.form.errors={};    
      },
      atualizar() {
        this.$Progress.start();      
        this.$http.put("/api/Monografia/" + this.form.id,this.form)
          .then(data => {
            this.basic.dialog = false;   
            window.getApp.$emit("APP_EDIT");
            this.carrega()
          })
          .catch((e) => {
            this.form.errors = e.response.data.errors;
            console.log(e.response.data.errors);
          });
        this.$Progress.finish();
      },
    busca_Monografia_User: function(id){
        this.$http.get("/api/Relatorio_Monografia/"+id).then(data => {
          
          this.Users_Monografias = data.data
          console.log(this.Users_Monografias);
          window.getApp.$emit("APP_SAVE");
          loader.hide();
        })
        .catch((e) => {
          console.log(e.response);
        });
    },
  }
}
</script>