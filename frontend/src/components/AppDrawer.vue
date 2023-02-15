<template>
  <v-navigation-drawer
  id="appDrawer"
    :mini-variant.sync="mini"
    fixed
    :color="red"
    app
    v-model="drawer"
    width="260"
  >
    <v-toolbar color="primary darken-1" dark>
      <!-- <img v-bind:src="computeLogo" height="36" alt="Vue Material Admin Template"> -->
      <v-toolbar-title class="ml-0 pl-3">
        <!-- <span class="hidden-sm-and-down"><img src="imagens/logo.png" style="width: 177px;position: relative;top: 5px;"></span> -->
        <h1>DMTE</h1>
      </v-toolbar-title>
    </v-toolbar>
    <vue-perfect-scrollbar class="drawer-menu--scroll" :settings="scrollSettings">
      <v-list dense expand>
        <template v-if="verificaMenu(item)"  v-for="(item, i) in menus">
           <!-- {{verificaMenu(item)}} -->
          <!--group with subitems-->
          <v-list-group v-if="item.items" :key="item.name" :group="item.group" :prepend-icon="item.icon"  no-action="no-action">
            <v-list-tile slot="activator" ripple="ripple">
              <v-list-tile-content>
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <template v-for="(subItem, i) in item.items">
              <!--sub group-->
              <v-list-group v-if="subItem.items" :key="subItem.name" :group="subItem.group"  sub-group="sub-group" >
                <v-list-tile slot="activator" ripple="ripple">
                  <v-list-tile-content>
                    <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile
                  v-for="(grand, i) in subItem.children"
                  :key="i"
                  :to="genChildTarget(item, grand)"
                  :href="grand.href"
                  ripple="ripple"
                >
                  <v-list-tile-content>
                    <v-list-tile-title>{{ grand.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list-group>
              <!--child item-->
              <v-list-tile
                v-else
                :key="i" :to="genChildTarget(item, subItem)" :href="subItem.href" :disabled="subItem.disabled" :target="subItem.target"   ripple="ripple">
                <v-list-tile-content>
                  <v-list-tile-title>
                    <span>{{ subItem.title }}</span>
                  </v-list-tile-title>
                </v-list-tile-content>

                <v-list-tile-action v-if="subItem.action">
                  <v-icon :class="[subItem.actionClass || 'success--text']">{{ subItem.action }}</v-icon>
                </v-list-tile-action>
                
              </v-list-tile>
            </template>
          </v-list-group>
          <v-subheader v-else-if="item.header" :key="i">{{ item.header }}</v-subheader>
          <v-divider v-else-if="item.divider" :key="i"></v-divider>
          <!--top-level link-->
          <v-list-tile
          else
            v-if="item.mostra && item.disabled"
            :to="!item.href ? { name: item.name } : null"
            :href="item.href"
            ripple="ripple"
            :target="item.target"
            rel="noopener"
            :key="item.name"     
  
            >
            <v-list-tile-action v-if="item.icon">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content v-if="item.title">
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action v-if="item.subAction">
              <v-icon class="success--text">{{ item.subAction }}</v-icon>
            </v-list-tile-action>
          </v-list-tile>
        </template>          
        <!-- <div class="center_imagem"><img class="image" src="imagens/unimontes.png" style="margin-left: 0%;"></div> -->
      </v-list>
   
    </vue-perfect-scrollbar>
       
  </v-navigation-drawer>

</template>
<style scoped>
.center_imagem {
    position: relative;
    width: 200px;
    height: 200px;
}
img {
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
}
.hide{
  visibility:hidden;
}
.show{
  visibility: visible;
}
.image {
    min-height: 50px
}
</style>
<script>
import menu from "@/api/menu";
import { vm } from "../main";
import VuePerfectScrollbar from "vue-perfect-scrollbar";

export default {
  name: "app-drawer",
  components: {
    VuePerfectScrollbar
  },
  props: {
    expanded: {
      type: Boolean,
      default: true
    }
  },
  data: () => ({
    mini: false,
    drawer: true,
    menus: menu,
    scrollSettings: {
      maxScrollbarLength: 160
    }
  }),
  computed: {
    computeGroupActive() {
      return true;
    },
    computeLogo() {
      return "/static/m.png";
    },
    sideToolbarColor() {
      return this.$vuetify.options.extra.sideNav;
    }
  },
  created() {
    var _this = this
    $.each(this.menus, function(index, value){
      console.log('value.rota',value.items);
      if(value.rota){
        if (vm.$session.get("dados_usuarios")){
          let result = vm.$session.get("dados_usuarios").permissoes;
          $.each(result, function(valor){
            if(_this.menus[index].rota!='publica'){      
              console.log("_this.menus[index].rota liberadas",_this.menus[index].show)      
              if(_this.menus[index].show!=false){
                if(_this.menus[index].rota==valor){
                  _this.menus[index].mostra=true;
                }
              }
            }else{
              console.log("_this.menus[index].rota publica",_this.menus[index])      
            }
            if(value.items){
              //console.log('titulo',value.title)
            }            
          })
        }       
      }
    })
    window.getApp.$on("APP_DRAWER_TOGGLED", () => {
      this.drawer = !this.drawer;
    });
  },

  methods: {
    verificaMenu(item){
      var result = vm.$session.get("dados_usuarios").permissoes;
      let propertyNames = Object.keys(result);      
      // console.log("verifica ",item,item.rota,propertyNames.includes(item.rota))
      if(item.rota=='publica'){
        return true
      }else{
        return propertyNames.includes(item.rota)
      }
      
    },
    genChildTarget(item, subItem) {
      if (subItem.href) return;
      if (subItem.component) {
        return {
          name: subItem.component
        };
      }
      return { name: `${item.group}/${subItem.name}` };
    }
  }
};
</script>


<style lang="stylus">
@import '../../node_modules/vuetify/src/stylus/settings/_elevations.styl';
#appDrawer {
  overflow: hidden;

  .drawer-menu--scroll {
    height: calc(100vh - 48px);
    overflow: auto;
  }
}
</style>
