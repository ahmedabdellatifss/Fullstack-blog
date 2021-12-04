
import Vue from 'vue'
import vuex from 'vuex'

Vue.use(vuex)


export default new vuex.Store({
    state:{
        counter : 1000
    },
    getters:{
        getCounter(state){
            return state.counter
        }
    },

    mutations: {
        changeTheCounter(state , data){
            state.counter += data
        }
    },
    actions:{
        changeCounterAction({commit} , data){
            commit('changeTheCounter' , data)
        }
    }


})
