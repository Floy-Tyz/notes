<template>

    <div class="border-2 border-[#3d3d3d] rounded-2xl px-4 py-6 flex flex-col  w-[25rem] h-[]">
        <div class="flex flex-row flex-wrap justify-between mb-6 w-full">
            <router-link :to="{name:'Card',params:{slug:item.slug}}">
                {{ item.name }}
            </router-link>
            <button @click="trueDelToDo(item.id)">
                X
            </button>
        </div>

        <TaskItem v-for="i in item.tasks" :i="i" :key="i.id"/>

    </div>

</template>

<script>

import TaskItem from "./TaskItem";
import {mapActions} from "vuex";

export default {
    name: "ToDoItem",
    components: {TaskItem},
    props: {item: Object},

    methods: {
        ...mapActions([
            'delToDo'
        ]),

        trueDelToDo(id) {
            if (confirm('уверены')){
                this.delToDo(id)
            }
        }

        // delToDo(id){
        //   console.log(id)
        //   this.$store.dispatch('delToDo', id)
        // }

    },

}
</script>

<style scoped>

</style>