<template>

    <div @mouseover="mouseOver(item.id)" class="border-2 border-[#3d3d3d] rounded-2xl px-4 py-6 flex flex-col  w-[25rem] h-[]">
        <div class="flex flex-row flex-wrap justify-between mb-6 w-full"  >
            <div class="flex flex-col items-start">
                <div>
                    <router-link :to="{name:'Card',params:{slug:item.slug, id:item.id}}">
                        {{ item.name }}
                    </router-link>
                    <button @click="trueDelToDo(item.id)">
                        X
                    </button>

                </div>
                <div v-for="task in printTasks" :key="task.id"  class="text-white text-sm" v-show="active">
                    dds
                    {{task.name}}
                </div>

            </div>

        </div>

<!--        <TaskItem v-for="i in item.tasks" :i="i" :key="i.id"/>-->

    </div>


</template>

<script>

import TaskItem from "./TaskItem";
import {mapActions, mapGetters} from "vuex";


export default {
    name: "ToDoItem",
    components: {TaskItem},
    props: {item: Object},
    data() {
        return {active: false}
    },
    computed:{
        ...mapGetters({allTaskOfToDo:'allTaskOfToDo'}),

        printTasks(){
            return this.allTaskOfToDo(this.item.id)
        },
    },

    methods: {

        ...mapActions([
            'delToDo',
            'getTaskOfToDo'
        ]),

        trueDelToDo(id) {
            if (confirm('уверены')){
                this.delToDo(id)
            }
        },
        mouseOver(id){
            this.active = !this.active;
            if (this.active){
                this.getTaskOfToDo(id)
            }
        },


        // delToDo(id){
        //   console.log(id)
        //   this.$store.dispatch('delToDo', id)
        // }

    },


}
</script>

<style scoped>

</style>