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
                      <span class="headline">{{ editmode ? 'Editar monografia' : 'Adicionar monografia' }}</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                      <v-container grid-list-md>
                        <v-layout wrap>
                          <v-flex xs12 sm5 md4> 
                          <v-select
                          :items="Professor"
                          v-model="form.fk_professor"
                          label="Selecione o nome do professor"
                          item-text="professor"
                          item-value="id"
                          clearable
                          filled
                          single-line                              
                          ></v-select>                                         
                          </v-flex> 
                          <v-flex xs12>
                            <v-text-field
                              v-model="form.nome"
                              name="name"
                              label="Nome"                            
                            ></v-text-field>
                            <div v-if="form.errors.name" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.name[0] }}</div>
                          </v-flex>                         
                            <v-flex xs12>
                            <v-text-field
                              :type="'file'"
                              v-model="form.file"
                              name="file"
                              label="file"                            
                            ></v-text-field>
                            <div v-if="form.errors.file" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.file[0] }}</div>      
                          </v-flex>
                          <v-flex xs12 class="posicao"  style="margin-left: 5px;">
                            <v-checkbox                         
                              @click.native="checked = !checked"
                              primary
                              hide-details
                              class="flutuar"
                              v-if="editmode"
                            ></v-checkbox>
                          </v-flex>
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
                      <v-btn color="blue darken-1" type="submit">Salvar</v-btn>
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
                  <template slot="items" slot-scope="props" v-if="props.item.id > 1">
                    <td>
                      <v-checkbox primary hide-details v-model="props.selected"></v-checkbox>
                    </td>
                    <td>{{ props.item.name }}</td>
                    <td>{{ props.item.marca }}</td>
                    <td>
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
        dados:[],
        Professor:[],
        monografias:[],
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
          nome: "",	
          fk_professor: "",	
          file: "",	
          errors:{}
        }),
        complex: {
          selected: [],
          headers: [
            {
              text: "Nome",
              align: "left",
              value: "name"
            },
            { text: "Marca", value: "marca" },
            { text: "Ações", value: "action" ,align:"left"}
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
        this.$http.post("/api/monografia",this.form).then(data => {
            console.log(data);
            this.limparCampos()                    
            this.carrega()
            window.getApp.$emit("APP_SAVE");
          })
          .catch((e) => {
            this.form.errors = e.response.data.errors;
            console.log(e.response.data.errors);
            //loader.hide();
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
        this.form.username = dados.username;
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
      carrega(){
        this.$http.get("/api/Monografia")
          .then(data => {
              console.log('data.data',data.data)
              this.dados = data.data
          })
          .catch(() => {});
          this.$http.get("/api/Monografia").then(({ data }) => (this.monografias=data));    
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
      }
    },
    computed: {
      loadDados() {
      }
    },
    mounted(){
      this.$http.get("/api/Professor").then(({ data }) => (this.Professor=data)); 
      this.$http.get("/api/Monografia").then(({ data }) => (this.monografias = data)); 
      this.carrega()
    },
    created() {
    }
  };
  </script>