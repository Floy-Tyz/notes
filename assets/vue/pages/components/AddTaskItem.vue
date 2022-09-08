<template>
  <div class="flex flex-col items-start">
    <div class="text-sm">
      задача
    </div>
    <input type="text" class="w-44 h-5 rounded-sm p-1 ml-0 text-black text-sm active:ring-0"/>
  </div>

</template>

<script>
import {mapState} from "vuex";

export default {
  name: "AddTaskItem",

  computed: {
    ...mapState({
      entities: state => state.todos
    })
  },
  methods: {
    updateMessage (e) {
      this.$store.commit('updateMessage', e.target.value)
    }
  },

}
</script>

<style scoped>

</style>