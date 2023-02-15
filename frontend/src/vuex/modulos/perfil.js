import Vue from 'vue'
//import idbs from '../../api/indexedDBService'
var storeName = 'listaPerfis'

var self = Vue.prototype
export default {
  state: {
    PerfilList: [],
    PerfilShow: [],
    PerfilView: {},
    perfis: [],
    dataFields: ['perfis']    
  },

  mutations: {
    updatePerfilList(state, data) {      
      //state.perfil = [];
      //console.log("data ",data)
      state.perfis.push(data);    
      state.PerfilList = data;    
    },
    updatePerfilhow(state, data) {
      state.Perfilhow = data;
    },
    updatePerfilView(state, data) {
      state.PerfilView = data;
    },
  },

  actions: {    
    getAllPerfil(context) {
      //console.log('context '+JSON.stringify(context));
      self.$http.get("api/getAllPerfil").then(response => {      
        context.dispatch('saveDados')        
        context.commit("updatePerfilList", response.data);
      }).catch((e) => {
      });
    },    
    getPerfil(context) {
      self.$http.get("api/perfil").then(response => {             
        console.log("updatePerfilList", response.data);
        context.commit("updatePerfilList", response.data);
      })
    },
    getPerfilId(context, id) {
      self.$http.get("api/perfil/" + id).then(response => {
        context.commit("updatePerfilShow", response.data);
      });
    },

    SalvaPerfil(context, params) {
      params.post("api/perfil", params).then(response => {
        context.commit("updatePerfilList", response.data);
      });      
    },
    updatePerfil(context, params) {
       self.$http.put("api/perfil/" + params.id, params).then(response => {
         context.commit("updatePerfilList", response.data);
       });
    },
    removePerfil(context, id) {
      self.$http.delete("api/perfil/" + id);
    },   
  }
};