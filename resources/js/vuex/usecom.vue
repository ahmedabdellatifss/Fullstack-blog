<template>
    <div>
        <div class="content">
			<div class="container-fluid">
                    <h1>I will show how all other components react to changes</h1>
                    <h2>The master component : {{counter}}</h2>
                <div>
                    <comA></comA>
                </div>
                <div>
                    <comB></comB>
                </div>
                <div>
                    <comC></comC>
                </div>

                <Button type="info" @click="changeCounter">Change the state of the counter</Button>
			</div>

        </div>

    </div>
</template>


<script>
import comA from './comA'
import comB from './comB'
import comC from './comC'
import {mapGetters} from 'vuex'
export default {
    data(){
        return {

        }
    },
    methods : {

    },
    computed : {
        ...mapGetters({
            'counter' :'getCounter'
        })
    },
    methods : {
        changeCounter(){
            this.$store.dispatch('changeCounterAction', 1)
            //this.$store.commit('changeTheCounter', 1)
        },

    },
    created(){
        console.log(this.$store.state.counter)
    },
    components : {
        comA,
        comB,
        comC
    },
    watch : {

    }
}
</script>
