import Vue from 'vue'
// import idbs from '../../api/indexedDBService'
var storeName = 'listaPerfis'

var self = Vue.prototype
export default {
  state: {
    PermissaoList: [],
    PermissaoShow: [],
    PermissaoView: {},
    perfis: [],
    dataFields: ['perfis']    
  },

  mutations: {
    updatePermissaoList(state, data) {      
      state.perfis.push(data);    
      state.PermissaoList = data;    
    },
    updatePermissaohow(state, data) {
      state.Permissaohow = data;
    },
    updatePermissaoView(state, data) {
      state.PermissaoView = data;
    },
  },

  actions: {    
    getAllPermissao(context) {
      self.$http.get("api/getAllPermissao").then(response => {      
        context.dispatch('saveDados')        
        context.commit("updatePermissaoList", response.data);
      }).catch((e) => {
      });
    },    
    getPermissao(context) {
      self.$http.get("api/permissao").then(response => {            
        console.log("Retorno com internet ",response.data);
        context.commit("updatePermissaoList", response.data);
        
      })
    },
    getPermissaoId(context, id) {
      self.$http.get("api/permissao/" + id).then(response => {
        context.commit("updatePermissaoShow", response.data);
      });
    },

    SalvaPermissao(context, params) {
      params.post("api/permissao", params).then(response => {
        context.commit("updatePermissaoList", response.data);
      });      
    },
    updatePermissao(context, params) {
       self.$http.put("api/permissao/" + params.id, params).then(response => {
         context.commit("updatePermissaoList", response.data);
       });
    },
    removePermissao(context, id) {
      self.$http.delete("api/permissao/" + id);
    },
  }
};