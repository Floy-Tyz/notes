<template>
  <Header/>


  <router-view></router-view>
</template>

<script>
import Header from "@/components/Header";
import Main from "@/pages/Main";
import SecondPage from "@/pages/SecondPage";
import ThirdPage from "@/pages/ThirdPage";
export default {
  name: 'App',
  components: {
    Header,
    // eslint-disable-next-line vue/no-unused-components
    Main,
    // eslint-disable-next-line vue/no-unused-components
    SecondPage,
    // eslint-disable-next-line vue/no-unused-components
    ThirdPage
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin: 0;
  padding: 0;
}
</style>
