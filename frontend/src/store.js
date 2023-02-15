import Vue from "vue";
import Vuex from "vuex";
import pagination from './components/shared/pagination'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    pagination: pagination
}  
});
