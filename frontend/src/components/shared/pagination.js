import Vue from 'vue'
export default {
    state: {
        getList: []
    },
    mutations: {
        updateList (state, data) {
            state.getList = data
        }
    },
    actions: {
        clearRegistries(context, config){
            context.commit('updateList', [])
        },
        getRegistries (context, config) {
            if(!config.page){
                config.page=1
            }
            if(!config.limit){
                config.limit=200
            }
            if(config.like) {
              Vue.http.get('api/' + config.resource + '?limite=' + config.limit + '&page=' + config.page+ '&like=' + config.like).then(response => {
                context.commit('updateList', response.data)
              })
            }else{
              Vue.http.get('api/' + config.resource + '?limite=' + config.limit + '&page=' + config.page).then(response => {
              context.commit('updateList', response.data)

              })
            }
        }
    }
}
