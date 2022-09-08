<template>
<div class="border-2 border-[#3d3d3d] rounded-2xl px-4 py-6 flex flex-col  ">
  <div class="flex flex-col text-base items-start  ">
    <div>
      Название карточки
    </div>
    <input type="text" class="w-44 h-5 rounded-sm p-1 ml-0 text-black text-sm active:ring-0"/>
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

import AddTaskItem from "@/pages/components/AddTaskItem";
import {mapState} from "vuex";
export default {
  components: {AddTaskItem},
  data() {
    let isAdd = 0
    return {
      isAdd
    }
  },
  computed: {
    ...mapState({
      entities: state => state.todos
    })
  },
  methods:{
    addTaskItem: function (){
      console.log(this.isAdd)
      this.isAdd = this.isAdd+1
    }
  },

  name: "AddToDoItem",
  props:['item']
}
</script>

<style scoped>

</style>