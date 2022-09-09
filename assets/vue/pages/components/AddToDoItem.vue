<template>
<div class="border-2 border-[#3d3d3d] rounded-2xl px-4 py-6 flex flex-col  ">
  <div class="flex flex-col text-base items-start  ">
    <div>
      Название карточки {{ lastToDoTitle }}
    </div>

    <input @keyup.enter='createTodos' :value="title" type="text" class="w-44 h-5 rounded-sm bg-zinc-800 p-1 ml-0 text-white text-sm active:ring-0"/>
  </div>
  <div class="mt-5 space-y-2">
    <AddTaskItem v-for="item in isAdd" :item="item" :key="item" />
    <button @click="addTaskItem">
      +
    </button>
  </div>
</div>
</template>

<script>

import AddTaskItem from "./AddTaskItem";
import {mapState, mapMutations} from "vuex";
import store from "../../store/store";
export default {
  components: {AddTaskItem},
  data() {
    let isAdd = 0
    let ItemToDo = {}
    return {
      isAdd
    }
  },
  computed: {
    ...mapState({
      entities: state => state.todos,
      //title: state=>state.todos // [state.todos.length-1].title
    }) ,

    lastToDoTitle(){
      if (this.entities.length){
        return this.entities[this.entities.length-1].title
      }

    }
  },
  methods:{

    createTodos(e){
      store.commit('createTodos', e.target.value)
    },

    addTaskItem: function (){
      console.log(this.entities)
      this.isAdd = this.isAdd+1
    },

  },

  name: "AddToDoItem",
  props:['item']
}
</script>

<style scoped>

</style>