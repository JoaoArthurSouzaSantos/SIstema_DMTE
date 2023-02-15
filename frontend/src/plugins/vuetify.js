import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import 'vuetify/src/stylus/app.styl'
import '../theme/default.styl'
Vue.use(Vuetify, {
  theme: {
    primary: '#00897B',
    secondary: '#212121',
    accent: '#82B1FF',
    error: '#FF5252',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FFC107',
    topo:"#43A047"
  },
  customProperties: true,
  iconfont: 'fa4',
})
