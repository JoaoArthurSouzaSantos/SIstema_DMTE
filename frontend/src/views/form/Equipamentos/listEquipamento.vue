<template>
    <div id="pageTable">
      <v-container grid-list-xl fluid>
        <v-layout row wrap v-bind="loadDados">
          <!-- <v-flex xl4></v-flex> -->
          <v-flex lg12>
            <div slot="widget-content">
             
              <v-dialog v-model="basic.dialog" persistent max-width="500px">
                <v-btn color="primary" dark slot="activator">Novo Registro</v-btn>
                <v-card>
                  <form @submit.prevent="editmode ? atualizar() : salvar()">
                    <v-card-title>
                      <span class="headline">{{ editmode ? 'Editar Usuário' : 'Adicionar Usuário' }}</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                      <v-container grid-list-md>
                        <v-layout wrap>
                          <v-flex xs12>
                            <v-text-field
                              v-model="form.name"
                              name="name"
                              label="Nome"                            
                            ></v-text-field>
                            <div v-if="form.errors.name" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.name[0] }}</div>
                          </v-flex>
  
                          <v-flex xs12>
                            <v-text-field
                              :type="'marca'"
                              v-model="form.marca"
                              name="marca"
                              label="Marca"                            
                            ></v-text-field>
                            <div v-if="form.errors.marca" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.marca[0] }}</div>
                          </v-flex>

                          <v-flex xs12>
                                <v-text-filde
                                :items="estado"
                                v-model="form.estado"
                                label="Selecione"
                                item-text="estado"
                                item-value="Estado"
                                single-line                              
                                ></v-text-filde>
                          <div v-if="form.errors.estado	" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.estado	[0] }}</div>
                          </v-flex>
  
                          <v-flex xs12>
                                <v-text-filde
                                :items="CA"
                                v-model="form.CA"
                                label="Selecione"
                                item-text="CA"
                                item-value="CA"
                                single-line                              
                                ></v-text-filde>
                          <div v-if="form.errors.CA" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.CA[0] }}</div>
                          </v-flex>

                          <v-text-field
                              :type="'modelo'"
                              v-model="form.modelo"
                              :disabled="checked"
                              name="modelo"
                              label="Modelo"                            
                            ></v-text-field>
                            <div v-if="form.errors.modelo" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.modelo[0] }}</div>
                          
                          <v-flex xs12 class="posicao"  style="margin-left: 5px;">
                            <v-checkbox                         
                              @click.native="checked = !checked"
                              primary
                              hide-details
                              class="flutuar"
                              v-if="editmode"
                            ></v-checkbox>
                          </v-flex>

                        </v-layout>
                      </v-container>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="blue darken-1" flat @click.native="fechaModal()">Fechar</v-btn>
                      <v-btn color="blue darken-1" type="submit" flat>Salvar</v-btn>
                    </v-card-actions>
                  </form>
                </v-card>
              </v-dialog>
            </div>
            <v-card>
              <v-toolbar card color="white">
                <v-text-field
                  flat
                  solo
                  prepend-icon="search"
                  placeholder="Busca"
                  v-model="search"
                  hide-details
                  class="hidden-sm-and-down"
                ></v-text-field>
                <v-btn icon>
                  <v-icon>filter_list</v-icon>
                </v-btn>
              </v-toolbar>
              <v-divider></v-divider>
              <v-card-text class="pa-0">
                <v-data-table
                  :headers="complex.headers"
                  :search="search"
                  :items="dados"
                  :rows-per-page-items="[10,25,50,{text:'Todos','value':-1}]"
                  rows-per-page-text="Itens por página"
                  no-results-text="Nenhum dado encontrado"
                  no-data-text= "Não há dados disponí­veis"                
                  class="elevation-1"
                  item-key="id"
                  select-all
                  v-model="complex.selected"
                >
                  <template slot="items" slot-scope="props" >
                    <td>
                      <v-checkbox primary hide-details v-model="props.selected"></v-checkbox>
                    </td>
                    <td>{{ props.item.name }}</td>
                    <td>{{ props.item.estado }}</td>
                    <td>{{ props.item.fabricante }}</td>
                    <td class="text-xs-center">
                      <v-btn
                        @click.native="getDados(props.item)"
                        depressed
                        outline
                        icon
                        fab
                        dark
                        color="primary"
                        small
                      >
                        <v-icon>edit</v-icon>
                      </v-btn>
                      <v-btn
                        depressed
                        outline
                        icon
                        fab
                        dark
                        color="pink"                      
                        small
                        @click.native="excluir(props.item.id)"
                      >
                        <v-icon>delete</v-icon>
                      </v-btn>
                    </td>
                  </template>
                  <template slot="pageText" scope="{ pageStart, pageStop, itemsLength }">
                          {{ pageStart }}-{{ pageStop }} de {{ itemsLength }}
                  </template>                
                </v-data-table>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </div>
  </template>
  <style scope="">
  .flutuar {
    position: absolute;
    left: -17px;
    top: -2px;
  }
  .posicao {
    position: relative;
  }
  .theme--light.v-messages {
    display: none !important;
  }
  .v-text-field {
    padding-top: 2px !important;
    margin-top: 2px !important;
  }
  .v-input--selection-controls__ripple {
    height: 31px !important;
    width: 34px !important;
    left: -17px !important;
    top: calc(42% - 24px) !important;
  }
  </style>
  
  <script>
  import VWidget from "@/components/VWidget";
  import { Message, MessageBox } from "element-ui";
  import { vm } from "../../../main";
  export default {
    components: {
      VWidget
    },
    data() {
      return {
        loading: false,
        avisos: {},
        search: "",
        perfil:[],
        dados:[],
        checked: false,
        editmode: false,
        basic: {
          dialog: false
        },
        select: { texto: 'Usuário', id: '0' },
        items: [
          { texto: 'Usuário', id: '0' },
          { texto: 'Administrativo', id: '1' },
        
        ],      
        fullscreen: {
          dialog: false,
          notifications: false,
          sound: true,
          widgets: false
        },
        form: new Form({
          id: "",
          name: "",	
          CA: "",
          estado: "",
          marca: "",
          valor: "",
          file: "",
          modelo: "",	
          errors:{}
        }),
        complex: {
          selected: [],
          headers: [
            {
              text: "name",
              align: "left",
              value: "name"
            },
            { text: "Estado", value: "estado" },
            { text: "Marca", value: "marca"},
            { text: "Ações", value: "action", align: "center" }
          ]
        }
      };
    },
    methods: {
      fechaModal: function() {
        this.editmode = false;
        this.checked = false;
        this.limparCampos()   
      },
      salvar: function() {
        this.$Progress.start();
        let loader = this.$loading.show();      
        this.$http.post("/api/Equipamento",this.form).then(data => {
            this.limparCampos()                    
            window.getApp.$emit("APP_SAVE");
            
          })
          .catch((e) => {
            this.form.errors = e.response.data.errors;
            console.log(e.response.data.errors);
          });
        this.$Progress.finish();
        
      },
      getDados: function(dados) {
        this.editmode = true;
        this.checked = true;
        this.basic.dialog = true;
        this.form.id = dados.id;
        this.form.name = dados.name;
        this.form.perfil = dados.perfil;
        this.form.password = dados.password;
        this.form.marca = dados.marca;
      },
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
          if(vm.$session.get("dados_usuarios").id == id){
              window.getApp.$emit("APP_ERRO_DELETE");
          }else{
            _this.$http.delete("/api/Equipamento/"+id)
              .then(data => {
                //console.log(data);
                window.getApp.$emit("APP_DELETE");
                _this.$store.state.users.UserList.data
                this.carrega()            
              })
              .catch(() => {});          
          }
        });
      },
      limparCampos:function(){
      Object.assign(this.$data.form,this.$options.data().form)
      this.form.errors={};    
      },
      carrega(){
        this.$http.get("/api/Equipamento")
          .then(data => {
              console.log('data.data',data.data)
              this.dados = data.data
          })
          .catch(() => {});
        this.$http.get("/api/Equipamento").then(({ data }) => (this.materiais=data));        
      },
      atualizar() {
        this.$Progress.start();
        let loader = this.$loading.show();      
        this.$http.put("/api/Equipamento/" + this.form.id,this.form)
          .then(data => {
            this.basic.dialog = false;   
            window.getApp.$emit("APP_EDIT");
            this.carrega()
          })
          .catch((e) => {
            this.form.errors = e.response.data.errors;
            console.log(e.response.data.errors);
            loader.hide();
          });
        this.$Progress.finish();
      }
    },
    computed: {
      loadDados() {
      this.carrega()
      }
    },
    mounted(){
 
    },
    created() {
    }
  };
  </script>