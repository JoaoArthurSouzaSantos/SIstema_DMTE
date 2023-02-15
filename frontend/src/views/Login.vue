<template>
  <v-app id="login" class="primary">
    <v-content>
      <v-container fluid fill-height>
        <div id="fundo_principal"></div>
        <v-layout align-center justify-center >
          <v-flex xs12 sm8 md4 lg4>
            <v-spacer></v-spacer>
            <br><br><br><br><br><br>
            <v-card class="elevation-1 pa-3">
              <v-card-text>
                <div class="layout column align-center">
                  <br>
                </div>
                <v-form>
                   <!-- <label class="titulo">Informa seu usu??rio</label> -->
                  <v-flex xs12>
                    <br><br><br>
                    <v-text-field
                      append-icon="person"
                      name="login"
                      label="Login"
                      type="text"
                      ref="usuario"
                      v-model="model.username"
                      @keyup.enter.native="focusInput()"
                      
                    ></v-text-field>
                  </v-flex>

                  <label class="titulo">Informe a senha</label>
                  <v-text-field
                    :append-icon="icone"
                    @click:append="mostraSenha()"
                    name="password"
                    id="password"
                    :type="tipo_campo"
                    v-model="model.password"
                    ref="password"
                    @keyup.enter.native="login"
                  ></v-text-field>
                  <br><br>
                </v-form>
              </v-card-text>
              <div class="login-btn">
                <v-spacer></v-spacer>
                <v-btn texto-branco block color="laranja"  @click="login" :loading="loading">ENTRAR</v-btn>
              </div>

           
            </v-card>
          <br>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import Vue from "vue";
import { CONFIG } from "./../config";
import axios from "axios";

Vue.use(axios);
import { Message, MessageBox } from "element-ui";


export default {
  name: 'login',
  data() {
    return {
      loading: false,
      tipo_campo:"password",
      icone:"fa-eye-slash",
      loader: null,
      visivel:false,
      loading1: false,
      model: {
        username: "",
        password: ""
      },
    }
  },
  mounted() {
    this.$refs.usuario.focus();
  },
  watch: {
    loader () {
      const l = this.loader;
      this[l] = !this[l];

      setTimeout(() => {
        this[l] = false;
        this.visivel=false;

      }, 3000);
      this.loader = null;
    }
  },   
  methods: {

    focusInput() {
      if(this.model.username==""){
        this.$refs.usuario.focus();
      }else{
        this.$refs.password.focus();
      }
    },    

    mostraSenha(){
      if(this.tipo_campo=="password"){
        this.tipo_campo="text"
        this.icone="fa-eye"        
      }else{
        this.tipo_campo="password"
        this.icone="fa-eye-slash"                
      }

    },
    login() {
      let data = {
        grant_type: "password",
        client_id: CONFIG.client_id,
        client_secret: CONFIG.client_secret,
        username: this.model.username,
        password: this.model.password,
        scope: ""
      };
      console.log('data',data)
      //axios.post("oauth/token", data).then(res => {
      this.$http.post("oauth/token", data).then(res => {
          localStorage["token_sistema"] = JSON.stringify(res.data);
          this.isAuthenticated = true;       
          this.$session.start();
          this.$http.get("api/getUsuarios").then(response => {
            this.$session.set("dados_usuarios", response.data);
            this.$router.go("/dashboard");
            loader.hide();            
            console.log("logou");
          })
          .catch(() => {            
            console.log('Usuário não logado');
          });                     
      })
      .catch((e) => {
        this.model.password="";
        window.getApp.$emit("ERROR_LOGIN");
      });      
    }
  }
}
</script>
<style scoped lang="css">
#fundo_principal {
  height: 45%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  content: "";
  z-index: 0;
  background-color: #4c4c4c !important;
  border-color: #083244 !important;  
}
#login {
  height: 45%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  content: "";
  z-index: 0;
}
.theme--light.v-sheet {
    background-color: #fff !important;
    border-color: #000000;
    color: rgba(0,0,0,0.87);
    border-radius: 8px;
    box-shadow: 0px 2px 7px rgb(10 10 10 / 4%) !important;
}

.primary {
    background-color: #fff !important;
    border-color: #000000 !important;
}

.split-bg {
  height: 50%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  content: "";
  z-index: 0;
}
.fundo-verde{
  background:#1c501e;
  padding: 0px !important;
}
.fundo-branco{
  background:#fff !important;
  padding: 0px !important;
}
.borda-redonda{
  border-radius: 11px;
}
.texto-branco{
  color:#fff;
}
.cinza{
  background-color: #c5c5c5 !important;
  color: #333;
  border-radius: 15px;
  top: -21px;
  font-weight: 300;
}
.laranja{
  background-color: #4ef11c !important;
  color: white;
  height: 41px;
  border-radius: 7px;
  top: -21px;
  font-size: 14px;
  font-weight: 400;
}
.titulo{
  font-weight: 300;
  font-size: 15px;
  color: #000200;
}
.toolbar-background-md{
  background-color: #1c501e;
}
.v-icon.v-icon--link {
    color: rgb(28, 80, 30) !important;
}

.v-card {
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    text-decoration: none !important;
}
.v-form{
  position: relative;
  top: -32px;
}

.theme--light.v-icon, .theme--light.v-list {
    color: #296b2b !important;
}
</style>

};
</script>
<style scoped lang="css">
  #login {
    height: 50%;
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    content: "";
    z-index: 0;
  }
</style>
