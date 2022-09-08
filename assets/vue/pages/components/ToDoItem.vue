<template>
  <div class="border-2 border-[#3d3d3d] rounded-2xl px-4 py-6 flex flex-col  w-[25rem] h-[]">
    <div class="flex flex-row justify-between mb-6">
      <div>
        {{ item.title }}
      </div>
      <button>
        X
      </button>
    </div>

    <TaskItem v-for="i in item.tasks" :i="i" :key="i.id"/>

  </div>
</template>

<script>


import TaskItem from "@/pages/components/TaskItem";

export default {
  name: "ToDoItem",
  components: {TaskItem},
  props: {item: Object},

}
</script>

<style scoped>

</style>