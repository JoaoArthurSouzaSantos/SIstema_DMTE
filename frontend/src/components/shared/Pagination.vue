<template lang="html">
<center>
  <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item" :class="{disabled: active == 1}" >
      <a ref="primeiro" class="page-link" href="" @click.prevent="navigate(1)">&laquo;</a></li>
    <li class="page-item" :class="{active: n == active}" v-for="n in parseInt(total)" v-if="Math.abs(n - active) < 3 || n == parseInt(total) || n == 1">
      <a :id="'botao' + n" v-bind:key="n" href="" @click.prevent="navigate(n)"" class="page-link" :class="{current: active === n, last: (n == parseInt(total) && Math.abs(n - active) > 3), first:(n == 1 && Math.abs(n - active) > 3)}">{{ n }}</a>
    </li>
    <li class="page-item" :class="{disabled: active == total}"><a class="page-link" href="" @click.prevent="navigate(total)">&raquo;</a></li>
  </ul>
  <p>Exibindo página {{ active }} de {{ total }}, total de {{ totalRegistries }} registros.</p>
  </nav>

</center>

</template>
<script>
    import { vm } from '../../main';
    export default{
        name: 'pagination',
        props: [
            'totalPerPage',
            'resource',
            'texto',
            'campo'
        ],
        data: function (){
            return {
                active: 1,
                paginaAtual:1,
                campoTexto:''
            }
        },
        computed: {
            registries () {
                return this.$store.state.pagination.getList
            },
            total(){
                return this.registries.last_page || 0
            },
            totalRegistries(){
                return this.registries.total || 0
            }
        },

        methods: {
          navigate: function(n) {
              let loader = this.$loading.show()
              this.active = n
              let config = {
                  resource: this.resource,
                  limit: this.totalPerPage,
                  like: this.campo+','+this.campoTexto,
                  page: n
              }
              //this.paginaAtual = n
              this.$store.dispatch('getRegistries', config)
              setTimeout(()=>{
                loader.hide()
              },200)
          }
        },
        created (){
          var self = this
          vm.$on('inputSearch', function (obj) {
              self.campoTexto = obj
              setTimeout(()=>{self.navigate(1)},200)
              self.$store.dispatch('getRegistries', {
                resource: self.resource,
                limit: self.totalPerPage,
                like: self.campo+','+self.campoTexto
              })
          })

          this.$store.dispatch('getRegistries', {
            resource: this.resource,
            limit: this.totalPerPage,
            like: this.campo+','+this.campoTexto
          })

          vm.$on('atualizaPagina', function (pg) {
            self.navigate(pg)
            console.log('Pagina atual pag '+self.active)
          })

        }
    }
</script>
<style scoped>
  ul {
    padding: 0;
    list-style-type: none;
  }

  a.first::after {
    content:''
  }

  a.last::before {
    content:''
  }
</style>
