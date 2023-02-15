import Vue from "vue";

import router from "./router";
import { vm } from "./main";

let getToken = function() {
  let token = localStorage["token_sistema"];
  if (!token) {
    token = null;
  }
  return JSON.parse(token);
};

let token = getToken();
router.beforeEach((to, from, next) => {
  token = getToken();
  //console.log("sessao " + JSON.stringify(vm.$session.get("dados_usuarios")));
  if (to.fullPath != "/login" && !localStorage["token_sistema"]) {
   //return next({ path: "/login" });
   //return next('/teste');
  } else if (to.fullPath == "/login" && localStorage["token_sistema"]) {
    //isAuthenticated= true
    return next({ path: "/" });
  }
  return next();
});


