<template>
  <v-app>
    <navbar />
    <v-main>
        <v-container>
          <router-view></router-view>
        </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Navbar from './components/Navbar'
export default {
  name: "App",
  components: {
    Navbar,
  },
}
</script>

<style scoped>

</style>