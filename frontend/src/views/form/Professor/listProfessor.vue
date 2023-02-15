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
                    <span class="headline">{{ editmode ? 'Editar Ativo' : 'Adicionar Ativo' }}</span>
                  </v-card-title>
                  <v-divider></v-divider>
                  <v-card-text>
                    <v-container grid-list-md>
                      <v-layout wrap>
                        <v-flex xs12 sm6 md4> 
                        <v-text-field
                          v-model="form.name"
                          :rules="nameRules"
                          :counter="30"
                          label="name"
                          required
                        ></v-text-field>
                        <v-text-field
                          v-model="form.Titulacao"
                          :counter="30"
                          label="Titulacao"
                          required
                        ></v-text-field>
                        <v-text-field
                          v-model="form.Situacao"
                          :counter="30"
                          label="Situacao"
                          required
                        ></v-text-field>
                        <v-text-field
                          v-model="form.Nivel"
                          :counter="30"
                          label="Nivel"
                          required
                        ></v-text-field>
                        <v-text-field
                          v-model="form.Email"
                          :rules="EmailRules"
                          :counter="30"
                          label="Email"
                          required
                        ></v-text-field>
                        <v-text-field
                          v-model="form.Email_Institucional"
                          :counter="30"
                          label="Email_Institucional"
                          required
                        ></v-text-field>
                        <v-text-field
                          v-model="form.Lattes"
                          :counter="30"
                          label="Lattes"
                          required
                        ></v-text-field>
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
                  <template slot="items" slot-scope="props" >
                    <td>
                      <v-checkbox primary hide-details v-model="props.selected"></v-checkbox>
                    </td>
                    <td>{{ props.item.name}}</td>
                    <td>{{ props.item.nome_funcao}}</td>
                    <td>{{ props.item.nome_setor}}</td>
                    <td>{{ props.item.nome_empresas}}</td>      
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
        busca_informacoes:[],
        setor: [],
        empresas: [],
        funcao: [],
        dados:[],
        itens:{
        icon: "account_circle",
        href: "#",
        slot: "activator",
        title: "Dados",
        rota: "publica",
        mostra:true,
      },
        checked: false,
        editmode: false,
        basic: {
          dialog: false
        },
        select: { texto: 'Funcionario', id: '0' },
        items: [
          { texto: 'Funcionario', id: '0' },
          { texto: 'Administrativo', id: '1' },
        
        ],      
        fullscreen: {
          dialog: false,
          notifications: false,
          sound: true,
          widgets: false
        },
        form: new Form({

          name:"",	
          funcao:"",
          setor:"",
          fk_setor:"",
		      fk_funcao:"",
		      fk_empresas_coaltech:"",
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
            { text: "Função", value: "nome-funcao",},
            { text: "Setor", value: "nome_setor",},
            { text: "empresas", value: "nome_empresas",},
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
        this.$http.post("/api/funcionario",this.form).then(data => {
            console.log("teste",data);
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
            _this.$http.delete("/api/funcionario/"+id)
              .then(data => {
                //console.log(data);
                window.getApp.$emit("APP_DELETE");
                //_this.$store.dispatch("getUser");
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
      atualizar() {
        this.$Progress.start();
        //let loader = this.$loading.show();      
        this.$http.put("/api/funcionario/" + this.form.id,this.form)
          .then(data => {
            this.basic.dialog = false;   
            window.getApp.$emit("APP_EDIT");
            //this.$store.dispatch("getUser");
            //loader.hide();
          })
          .catch((e) => {
            this.form.errors = e.response.data.errors;
            console.log(e.response.data.errors);
            //loader.hide();
          });
        //console.log(dados);
        this.$Progress.finish();
      }
    },
    computed: {
      loadDados() {
  
         //this.$http.get("/api/user").then(({ data }) => (console.log('perfil '+JSON.stringify(data.data))));
         //this.$http.get("/api/funcionario").then(({ data }) => (this.dados = data.data));    
         if(this.dados){
          return this.dados
         } 
        //console.log(this.$store.state.users.UserList.data);
        //return this.$store.state.users.UserList.data;
      }
    },
    mounted(){
          this.$http.get("/api/lista_funcionarios")
          .then(data => {
              console.log('data.data',data.data)
              this.dados = data.data
          })
          .catch(() => {});    
        this.$http.get("/api/setor").then(({ data }) => (this.setor = data)); 
        this.$http.get("/api/empresas").then(({ data }) => (this.empresas=data));
        this.$http.get("/api/funcao").then(({ data }) => (this.funcao=data)); 
    },

    created() {
      //this.$store.dispatch("getUser");
      //this.$Progress.start();
    }
  };
  </script>