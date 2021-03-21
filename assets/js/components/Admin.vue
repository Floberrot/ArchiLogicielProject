<template>
  <v-app-bar
    app
    absolute
    fixed
    color="white"
  >
  <div class="my-2">
            <v-btn
              color="success"
              fab
              large
              dark
              v-on:click="testAuthorize"
            >
              <v-icon>mdi-flash</v-icon>
            </v-btn>
          </div>
  </v-app-bar>
</template>

<script>
export default {
  methods: {
    testAuthorize () { 
      this.$axios.post("/admin/authorize/1",{
          isAuthorize: true,
          role: 'Membre'
      }) 
    },
  },
  name: "Admin"
}
</script>

<style scoped>

</style>