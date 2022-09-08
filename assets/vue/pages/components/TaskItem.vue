<template>
  <div class="flex flex-row start items-center">
    <div class="mr-auto">{{ i.text }}</div>
    <div>
<!--      <input type="checkbox" id="checkbox" @input="updateMessage" class="" />-->
<!--      <button class="ml-2">-->
<!--        X-->
<!--      </button>-->
    </div>

  </div>
</template>

<script>



import {mapState} from "vuex";

export default {
  name: "TaskItem",
  props: {i:Object},

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

  mounted() {
    console.log(this.entities)
  }

}
</script>

<style scoped>

</style>