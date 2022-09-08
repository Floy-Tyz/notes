

<template>
<div id="header">
  <a href="/" id="header-first">
    Главная
  </a>
  <a  href="/second">
    Страница 2
  </a>
  <a href="/third">
    Страница 3
  </a>
</div>

</template>

<style scoped>
#header{
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding-top: 2rem;
  padding-bottom: 2rem;
  color: white;
  margin: 0 0 0 2rem;

}


a{
  padding-right: 2rem;
  color: #d0d0d0;
  text-decoration: none;
  font-weight: lighter;
  font-size: 1rem;
}
#header-first{
  margin-right: auto;
  color: white;
  font-size: 2rem;
}


</style>

<script>

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Header"
}
</script>

