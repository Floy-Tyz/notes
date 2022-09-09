<template>
    <div class="flex flex-col items-center text-white space-y-6">
        <div class="text-white  rounded-2xl border-1 border-white w-[40rem]">
            <div class="text-white text-2xl pt-5">
                {{ getCardName }}
            </div>
            <Tasks v-for="task in getTasks" key="task.id" :task="task" />

        </div>
        <div>

            <input v-model="input" placeholder="text" type="text" class="w-44 h-5 rounded-sm p-1 ml-0 text-black text-sm active:ring-0"/>

            <button @click="addToTask" class="text-sm bg-red-50 rounded-xl p-3 text-black">
                Добавить
            </button>
        </div>


    </div>
</template>

<script>
import Tasks from "./components/Tasks";
import {mapActions, mapGetters, mapState} from "vuex";

export default {
    name: "CardToDo",
    components: {Tasks},
    data(){
        return {input:''}
    },
    computed: {
        ...mapState(['todos']),
        ...mapGetters({oneToDo: 'oneToDo', }),
        // ...mapActions(['getOneToDo'])

        getCardName() {
            // this.todo = this.oneToDo({slug: this.$route.params.slug})
            return this.oneToDo(this.$route.params.slug).name
        },
        getTasks(){
            return this.oneToDo(this.$route.params.slug).tasks
        }

    },
    methods:{
      ...mapActions(['addTask',]),

        addToTask(){
          console.log(this.$route.params.id,this.input)
          this.addTask({todoId:this.$route.params.id, text:this.input})
        },


    },




}
</script>

<style scoped>

</style>