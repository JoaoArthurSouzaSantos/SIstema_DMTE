import Vue from "vue";
import Vuex from "vuex";
//import createCache from "vuex-cache";

import permissao from "./modulos/permissao";
import perfil from "./modulos/perfil";
Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    permissao,
    perfil,
  }
  //plugins: [createCache()]
});

