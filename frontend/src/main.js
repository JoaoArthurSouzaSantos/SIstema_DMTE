import Vue from "vue";
import "./plugins/vuetify";
//import './plugins/canvasjs'
import "@/autenticacao";
import App from "./App.vue";
import router from "./router/";
import store from "./vuex/store";
import "roboto-fontface/css/roboto/roboto-fontface.css";
import "./assets/estilos.css";
import "font-awesome/css/font-awesome.css";
import axios from "axios";
//import VueAxios from "vue-axios";
import moment from 'moment';
import { isMobile } from 'mobile-device-detect';

import https from 'https';
//import i18n from './i18n'

import VueCookies from 'vue-cookies'

Vue.use(VueCookies)
Vue.$cookies.config('365d')
// import Vuex from 'vuex'
// Vue.use(Vuex)
Vue.use(moment)
window.moment = require('moment');

import 'moment/locale/pt-br'

const install = function (Vue, options) {

  window.moment = moment
  window.moment().locale('pt-br')

  Vue.prototype.moment = window.moment
}

export default { install }

import swal from "sweetalert2";
window.isMobile = isMobile
window.swal = swal;
window.Fire = new Vue();
const toast = swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

import VueProgressBar from "vue-progressbar";
Vue.use(VueProgressBar, {
  color: "rgb(143, 255, 199)",
  failedColor: "red",
  height: "3px"
});

Vue.use(axios);

window.axios = require("axios");

import { Form, HasError, AlertError } from "vform";
import "vue-loading-overlay/dist/vue-loading.css";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";

import { Message, MessageBox } from "element-ui";
export const vm = new Vue();
import Loading from "vue-loading-overlay";

import Highcharts from 'highcharts';

import HighchartsMore from 'highcharts/highcharts-more';
HighchartsMore(Highcharts);

Highcharts.setOptions({
  lang: {
    loading: 'Aguarde...',
    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
    shortMonths: ['Jan', 'Feb', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    exportButtonTitle: "Exportar",
    printButtonTitle: "Imprimir",
    rangeSelectorFrom: "De",
    rangeSelectorTo: "Até",
    rangeSelectorZoom: "Periodo",
    downloadPNG: 'Download imagem PNG',
    downloadJPEG: 'Download imagem JPEG',
    downloadPDF: 'Download documento PDF',
    downloadSVG: 'Download imagem SVG'
    // resetZoom: "Reset",
    // resetZoomTitle: "Reset,
    // thousandsSep: ".",
    // decimalPoint: ','
  }
});

import HighchartsVue from "highcharts-vue";

import VueSession from "vue-session";

import JQuery from 'jquery'
let $ = JQuery

import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)

Vue.use(VueSession, { persist: true });
Vue.use(Loading);
Vue.use(HighchartsVue);
Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$alert = MessageBox.alert;
Vue.prototype.$confirm = MessageBox.confirm;
Vue.prototype.$prompt = MessageBox.prompt;
Vue.prototype.$message = Message;
Vue.prototype.$eMobile = isMobile;

window.$ = require('jquery')
window.JQuery = require('jquery')

window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import VCurrencyField from 'v-currency-field'
import { VTextField } from 'vuetify/lib'  //Globally import VTextField

Vue.component('v-text-field', VTextField)
Vue.use(VCurrencyField, {
  locale: 'pt-BR',
  decimalLength: 2,
  autoDecimalMode: true,
  min: null,
  max: null,
  defaultValue: 0
})
Vue.component(VCurrencyField);
//LoginInterceptors.check_empty_token(router);
//LoginInterceptors.check_auth(router);
Vue.config.productionTip = false;

export const globalStore = new Vue({
  data: {
    MessageBox: "MessageBox",
    Message: "Message",
    Loading: "Loading",
    perfil_usuario: 0
  }
});
//import "./registerServiceWorker";
import wb from "./registerServiceWorker";
Vue.prototype.$workbox = wb;



let hostURL = window.location.hostname;
// alert(window.location.hostname)
process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0'
window.BASE_URL = `http://localhost/Sistema_DMTE/backend/public`;
Vue.prototype.$url_local_imagens = window.BASE_URL

const base = axios.create({
  baseURL : `http://localhost/Sistema_DMTE/backend/public`,
  // timeout : 10000, 
  headers: {
    'Access-Control-Allow-Origin': '*',
    "Content-Type": "application/json",
  },
  httpsAgent: new https.Agent({
    rejectUnauthorized: false
  }),
  withCredentials: false
})

import VueNativeNotification from 'vue-native-notification'
Vue.use(VueNativeNotification, {
  // Automatic permission request before
  // showing notification (default: true)
  requestOnNotify: true
})

axios.defaults.baseURL = window.BASE_URL;
//axios.defaults.withCredentials = false;
axios.defaults.headers = {
  'Access-Control-Allow-Origin': '*',
  "Content-Type": "multipart/form-data",
}
Vue.notification.requestPermission().then(console.log) // Prints "granted", "denied" or "default"    
Vue.prototype.$http = base

import LoginInterceptors from "./interceptors";
//import './registerServiceWorker'
LoginInterceptors.check_empty_token(router, base);
LoginInterceptors.check_auth(router, base);
LoginInterceptors.check_permission(router, base);

/* eslint-disable */
window.vue = new Vue({
  router,  
  store,
  appName: "Sistema_DMTE",
  render: h => h(App)
}).$mount("#app");

