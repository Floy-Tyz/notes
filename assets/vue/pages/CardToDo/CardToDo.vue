<template>
    <div class="text-white">
        <div v-for="task in oneToDo" key="task.id">

            <div>
                {{task.text}}
            </div>
        </div>
        <div class="text-white">
            {{getCard}}
        </div>
        <div class="flex flex-col items-start">
            <div class="text-sm">
                задача
            </div>
            <input type="text" class="w-44 h-5 rounded-sm p-1 ml-0 text-black text-sm active:ring-0"/>
        </div>
    </div>
</template>

<script>
import Tasks from "./components/Tasks";
import {mapActions, mapGetters, mapState} from "vuex";
import store from "../../store/store";

export default {
    name: "CardToDo",
    components: {Tasks},
    computed: {
        ...mapState(['todos']),
        ...mapGetters(['oneToDo']),
        // ...mapActions(['getOneToDo'])
        getCard(){


            return this.oneToDo(this.$route.params.slug)
        }
    },



}
</script>

<style scoped>

</style>