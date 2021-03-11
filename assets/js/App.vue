<template>
  <v-app>
    <div>
      <router-view></router-view>
      <router-link to="register">register</router-link>
    </div>
  </v-app>
</template>

<script>
export default {
name: "App",
}
</script>

<style scoped>

</style>