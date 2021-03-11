<template>
  <div class="card">
    <h1>Inscription</h1>
    <form action="" @submit.prevent="registerUser">
      <div class="form-group">
        <input type="email" v-model="email" class="form-control" placeholder="email">
        <input type="password" v-model="mdp" class="form-control" placeholder="mdp">
        <button type="submit">S'inscrire</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
name: "Register",
  data() {
    return{
      email: '',
      mdp: '',
    }
  },
  methods: {
    registerUser() {
      this.$axios
          .post('register', {
            email: this.email,
            mdp: this.mdp
          })
          .then(response => {
            console.log(response)
            let token = response.data.token
          })
    }
  }
}
</script>

<style scoped>

</style>