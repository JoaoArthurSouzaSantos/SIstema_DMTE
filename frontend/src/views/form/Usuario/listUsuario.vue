<template>
    <div id="pageTable">
      <v-container grid-list-xl fluid>
        <v-layout row wrap >
          <!-- <v-flex xl4></v-flex> -->
          <v-flex lg12>
            <div slot="widget-content">
              <v-dialog v-model="basic.dialog" persistent max-width="500px">
                <v-btn color="primary" dark slot="activator">Novo Registros</v-btn>
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
                              :items="'username'"
                              v-model="form.username"
                              name="username"
                              label="Usuário"                            
                            ></v-text-field>
                            <div v-if="form.errors.username" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.username[0] }}</div>
                          </v-flex>
                          <v-flex xs12>
                            <v-text-field
                              :items="'perfil'"
                              v-model="form.perfil"
                              name=" perfil"
                              label="perfil"                            
                            ></v-text-field>
                            <div v-if="form.errors.perfil" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors. perfil[0] }}</div>
                          </v-flex>
                          <v-flex xs12 class="posicao"  style="margin-left: 5px;">
                            <v-checkbox                         
                              @click.native="checked = !checked"
                              primary
                              hide-details
                              class="flutuar"
                              v-if="editmode"
                            ></v-checkbox>
                            <v-text-field
                              :items="'password'"
                              v-model="form.password"
                              :disabled="checked"
                              name="password"
                              label="Senha"                            
                            ></v-text-field>
                            <div v-if="form.errors.password" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.password[0] }}</div>
                            <v-text-field
                              :items="'type'"
                              v-model="form.type"
                              :disabled="checked"
                              name="type"
                              label="Tipo de usuario"                            
                            ></v-text-field>
                            <div v-if="form.errors.type" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.email[0] }}</div>
                            <v-text-field
                              :items="'email'"
                              v-model="form.email"
                              :disabled="checked"
                              name="email"
                              label="email"                            
                            ></v-text-field>
                            <div v-if="form.errors.email" class="help-block invalid-feedback text-xs-left is-invalid">{{ form.errors.type[0] }}</div>
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
                  <template slot="items" slot-scope="props" >
                    <td>
                      <v-checkbox primary hide-details v-model="props.selected"></v-checkbox>
                    </td>
                    <td>{{ props.item.name }}</td>
                    <td>{{ props.item.email }}</td>
                    <td>{{ props.item.username}}</td>
                    <td>{{ props.item.type}}</td>
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
        dados:[],
        items: [],
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
        usuarios:[],
        form: new Form({
          form:{
          id:'',
          name:'',
          type:'',
          username: '',
          email: '',
          perfil:'',
          password:'',
          file:"",},
        }),
        complex: {
          selected: [],
          headers: [
            {
              text: "Nome",
              align: "left",
              value: "name"
            },
            { text: "Email", value: "email" },
            { text: "Username", value: "username"},
            { text: "tipo de usúario", value: "type"},
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
        //let loader = this.$loading.show();      
        //this.form.post("/api/user").then(data => {
        this.$http.post("/api/User",this.form).then(data => {
            //console.log(data);
            this.limparCampos()                    
            window.getApp.$emit("APP_SAVE");
            //this.$store.dispatch("getUser");
            //loader.hide();
            //this.$router.push({ path: "/forms/CadastroUsuarios" });
            
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
          if(vm.$session.get("dados_usuarios").id == id){
              window.getApp.$emit("APP_ERRO_DELETE");
          }else{
            _this.$http.delete("/api/User/"+id)
              .then(data => {
                //console.log(data);
                window.getApp.$emit("APP_DELETE");
                //_this.$store.dispatch("getUser");
                this.carrega()
                _this.$store.state.users.UserList.data
                //this.$router.push({ path: "/forms/CadastroUsuarios" });
                
              })
              .catch(() => {});          
          }
        });
      },
      limparCampos:function(){
        this.basic.dialog = false;
        this.form.reset();
        this.form.errors={};    
      },
      carrega(){
        this.$http.get("/api/User")
          .then(data => {
              console.log('data.data',data.data)
              this.dados = data.data
          })
          .catch(() => {});
      this.$http.get("/api/User").then(({ data }) => (this.usuarios=data));    
      },
      atualizar() {
        this.$Progress.start();
        let loader = this.$loading.show();      
        this.$http.put("/api/User/" + this.form.id,this.form)
          .then(data => {
            this.basic.dialog = false;   
            window.getApp.$emit("APP_EDIT");
            //this.$store.dispatch("getUser");
            //loader.hide();
            //this.carrega()
          })
          .catch((e) => {
            this.form.errors = e.response.data.errors;
            console.log(e.response.data.errors);
            loader.hide();
          });
        //console.log(dados);
        this.$Progress.finish();
      }
    },
    computed: {
      loadDados() {
  
         //this.$http.get("/api/user").then(({ data }) => (console.log('perfil '+JSON.stringify(data.data))));
         //this.$http.get("/api/usuario").then(({ data }) => (this.dados = data.data));    
         //if(this.dados){
          //return this.dados
         //} 
        //console.log(this.$store.state.users.UserList.data);
        //return this.$store.state.users.UserList.data;
      }
    },
    mounted(){
        this.carrega()
    },
    created() {
      //this.$store.dispatch("getUser");
      //this.$Progress.start();
    }
  };
  </script>
  