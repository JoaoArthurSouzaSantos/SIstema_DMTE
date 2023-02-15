import Vue from "vue";
import { CONFIG } from "./config";
import axios from "axios";
import "./autenticacao";
import { vm } from "./main";
import router from "./router";


let getToken = function() {
  let token = localStorage["token_sistema"];
  if (!token) {
    token = "{}";
  }
  return JSON.parse(token);
};

let token = getToken();

let login = function(routes) {
  router.push("/login");
};

let refreshToken = function(request, tokens, router) {
  let data = {
    grant_type: "refresh_token",
    client_id: CONFIG.client_id,
    client_secret: CONFIG.client_secret,
    refresh_token: token['refresh_token'],
    scope: ""
  };
  
  console.log('data token',token['refresh_token'],data)
  request
    .post("oauth/token", data)
    .then(res => {
      console.log("TOKEN REFRESHED - -",res.data);
      localStorage["token_sistema"] = JSON.stringify(res.data);;
      request.headers.set("Authorization", "Bearer " + res.data.access_token);
    })
    .catch((err) => {
      console.log("erro-",err.response.status);
      if (err.response.status === 401 || err.response.status === 400) {
        localStorage.removeItem("token_sistema");
        window.location.href="#/login"    
      }
      
    });
};

export default {
  check_empty_token: function(router, base) { 
    var valido = 0;

    vm.$http.interceptors.response.use(response => response, error => {
      const status = error.response ? error.response.status : null
        
        console.log("status ",status, error.config)
        //console.log("status", status,router.history.current.path)
        if(status === 401 || status === 400) {
          if(router.history.current.fullPath != "/login") {
            //refreshToken(base,getToken(),router)
            localStorage.removeItem("token_sistema");
            window.location.href="#/login"           
          }
        }
        if(status == 422){  
          let e = {}
          e.response = error.response
          console.log('error interceptors',e)
          return Promise.reject(e);
          //return vm.$http(error.response.data);
        }else{
          return Promise.reject("error",error);
        }
    }); 
  },
  //checa se está autenticado
  check_auth: function(router, base) {  
    base.interceptors.request.use(function(config) {
      const token = getToken();
      if(token) {
        config.headers.Authorization = `Bearer ${token.access_token}`;
      }
      return config;
    }, function(err) {
        console.log('erro token ',err)
        return Promise.reject(err);
    });
  },

  //checa as pemissoes do usuarios
  check_permission: function(router, base) { 
    if (vm.$session.get("dados_usuarios")){
        var permissoes = vm.$session.get("dados_usuarios").permissoes      
        //var rota_permissao = Object.values(permissoes)
        router.beforeEach((to, from, next) => {          
          var contador = 0 
          let rota_atual = to.name                  
          if( rota_atual !="Dashboard"){
            $.each(permissoes, function(valor){
              if(valor === rota_atual){
                contador++
              }         
            })
          }else{
            contador=1
          }
          if(contador==0){
            //return next({ path: "/" });
          }
          return next();
        });
      }
  }
};