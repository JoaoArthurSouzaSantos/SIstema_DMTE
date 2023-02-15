import Vue from "vue";
import axios from "axios";

axios.defaults.baseURL='http://192.168.225.1:8080/'
axios.defaults.headers.common['autorization']=`bearer ${localstorage.getItem('token')}`

Vue.use({
    install(Vue){
        prototype.$http= axios
    }
})