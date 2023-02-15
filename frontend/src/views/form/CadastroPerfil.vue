<template>
    <div id="pageTable">
      <v-container grid-list-xl fluid>
        <v-layout row wrap>
          <!-- <v-flex xl4></v-flex> -->
          <v-flex lg12>
            <div slot="widget-content">
              <v-dialog v-model="basic.dialog" persistent max-width="800px">
                
                <v-card>    
                   <form @submit.prevent="editmode ? atualizar() : salvar()">
                    <v-card-title>
                      <span class="headline">{{ editmode ? 'Editar ' : 'Adicionar ' }}Perfil</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                      <v-container grid-list-md>
                        <v-layout wrap>
                          
                          <v-flex xs12>
                            <v-text-field
                              v-model="form.perfil"
                              name="perfil"
                              label="Perfil"                            
                            ></v-text-field>
                            <div v-if="form.errors.perfil" class="help-block invalid-feedback text-xs-left is-invalid">Campo Obrigatório.</div>
                          </v-flex>
  
                          <v-flex xs12 sm4 v-for="permissoes in permissao" :key="permissoes.index">
                            <v-checkbox v-model="form.permissao" :value="permissoes.id" :label="permissoes.texto" ></v-checkbox>
                          </v-flex>
  
                          <!-- <input @change="updateCapaEvento" type="file"> -->
                        </v-layout>
                      </v-container>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="blue darken-1" flat @click.native="fechaModal()">Fechar</v-btn>
                      <v-btn color="blue darken-1" :loading="saving" type="submit" flat>Salvar</v-btn>
                    </v-card-actions>
                  </form>
                </v-card>
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
                  :items="loadDados"
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
                    <td class="text-xs-center">{{ props.item.id }}</td>
                    <td class="text-xs-left">{{ props.item.perfil }}</td>
                    <td class="text-xs-center">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn
                          @click.native="getDados(props.item)"
                          depressed
                          outline
                          icon
                          fab
                          dark
                          color="primary"
                          small
                          v-on="on"
                        >
                        <v-icon>edit</v-icon>
                        </v-btn>
                      </template>
                      <span>Editar</span>
                    </v-tooltip>
  
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn
                          v-on="on"
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
                      </template>
                      <span>Excluir</span>
                    </v-tooltip>
                    </td>
                  </template>
                  <template slot="pageText" scope="{ pageStart, pageStop, itemsLength }">
                          {{ pageStart }}-{{ pageStop }} de {{ itemsLength }}
                  </template>                   
                </v-data-table>
              </v-card-text>
            </v-card>                
              </v-dialog>
            </div>
            
          </v-flex>
        </v-layout>
      </v-container>
    </div>
  </template>
  <style scoped >
  .v-label.theme--light{
    font-size: 14px !important;
  }
  .flutuar {
    position: absolute;
    left: -17px;
    top: -2px;
  }
  .cursor {
      cursor: default;
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
  .perfil.v-avatar img {
      border-radius: 0% !important;
  }
  .container.grid-list-md {
      padding: 15px !important;
      margin-top: 10px;
  }
  </style>
  
  <script>
  //import VWidget from "@/components/VWidget";
  //import { Message, MessageBox } from "element-ui";
  //import ImageInput from "@/components/Upload";
  import { vm } from "../../main";
  export default {
    components: {
      //VWidget,
      //ImageInput
    },
    props: {
      //dialogo: false
    },
    data() {
      return {
        loading: false,
        avisos: {},
        avatar: null,
        saving: false,
        saved: false,
        search: "",
        checked: true,
        editmode: true,     
        foto:null,
        permissao:[],
        basic: {
          dialog: false
        },
        fullscreen: {
          dialog: false,
          notifications: false,
          sound: true,
          widgets: false
        },
        form: new Form({
          id: "",
          perfil: "",
          permissao:[]
        }),
        complex: {
          selected: [],
          headers: [
            {
              text: "ID",
              align: "center",
              value: "id"
            },
            { text: "Perfil", value: "usuario" },
            { text: "Ações", value: "action", align: "center" }
          ]
        }
      };
    },
    watch:{
  
    },
    methods: {   
      fechaModal() {
        this.checked = true;
        this.editmode = false;
        this.form.reset();
        this.form.errors={}
        this.basic.dialog = false;
        //console.log("fechar modal");
      },
      limparCampos:function(){
        //this.fullscreen.dialog = false;
        this.form.reset();
        this.form.errors={};    
      },      
      getDados(dados) {
        var _this=this
        this.checked = true;
        this.editmode = true;
        this.basic.dialog = true;
        this.form.id = dados.id;
        this.form.permissao =[];
        $.each(dados.get_permissoes,function(index, valor){
          //console.log('valor ',valor.permissao_id)
          _this.form.permissao[index] = valor.permissao_id;
        });
        
        this.form.perfil = dados.perfil;
        //console.log('get_permissoes', dados.get_permissoes)
      },
      excluir: function(id) {      
        var id = id;
        var _this = this;
        MessageBox({
          title: "Responda",
          message: "Deseja excluir o registro?",
          type: "danger",
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
          showCancelButton: true
        }).then(function(action) {
        if (vm.$session.get("dados_usuarios").id) {
            _this.$http.delete("/api/perfil/" + id).then(data => {
              window.getApp.$emit("APP_DELETE");
              _this.$store.dispatch("getPerfil");
              _this.$store.state.perfil.PerfilList.data;
            })
            .catch(() => {});
          }
        });
      },    
      salvar: function() {
        this.$Progress.start();
        let loader = this.$loading.show(); 
             
        this.$http.post("/api/perfil",this.form).then(data => {
            console.log('data', data); 
            this.limparCampos();
            window.getApp.$emit("APP_SAVE");
            this.$store.dispatch("getPerfil");
          })
          .catch((e) => {
            this.form.errors = e.response.data.errors;
            console.log(e.response.data.errors);
          });
  
        loader.hide();
        this.$Progress.finish();
      },
      atualizar() {
        this.saving = true
        this.$Progress.start();
        let loader = this.$loading.show();      
        this.$http.put("/api/perfil/" + this.form.id, this.form).then(data => {
            //console.log('dados '+data);
            window.getApp.$emit("APP_EDIT");
            this.$store.dispatch("getPerfil");          
            //console.log(this.form)
            this.limparCampos();
            //loader.hide();
            setTimeout(() => this.saving = false, 1000)     
          })
          .catch((e) => {
            loader.hide();
            this.form.errors = e.response.data.errors;
            //console.log(e.response.data.errors);
          });
      }
    },
    computed: {
      loadDados() {
        //console.log('dados perfil ',this.$store.state.perfil.PerfilList.data);
        return this.$store.state.perfil.PerfilList.data;
      }
    },
    mounted() {
        var _this = this;
        // this.basic.dialog = true;
        // _this.editmode = false;    
        // _this.permissao = _this.$store.state.permissao.PermissaoList.data;
        //  console.log('chamou perfil ',_this.$store.state.perfil.PerfilList)
               
        vm.$on("dialogo_perfil", function() {
            _this.editmode = false;    
            _this.permissao = _this.$store.state.permissao.PermissaoList.data;
            console.log('chamou perfil ',_this.$store.state.perfil.PerfilList.data)
            _this.basic.dialog = true;
        });
  
    },
    created() {
      //console.log('created parametros');
      this.$store.dispatch("getPerfil");
      this.$store.dispatch("getPermissao");
      //this.$Progress.start();
    }
  };
  </script>