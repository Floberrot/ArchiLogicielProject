<template>
  <v-app-bar
    app
    absolute
    fixed
    color="white"
  >
    <v-app-bar-nav-icon></v-app-bar-nav-icon>

    <v-toolbar-title>Title</v-toolbar-title>

    <v-spacer></v-spacer>

    <v-btn icon v-on:click="test()">
      test
    </v-btn>

    <v-btn icon>
      <v-icon>mdi-account</v-icon>
    </v-btn>

    <v-btn icon>
      <v-icon>mdi-dots-vertical</v-icon>
    </v-btn>
  </v-app-bar>
</template>

<script>
export default {
  methods: {
    test () { 
      this.$axios.post("/change/privacy/9",{
        valueStatusPrivacy: false
      }) 
    },
  },
  name: "Navbar"
}
</script>

<style scoped>

</style>