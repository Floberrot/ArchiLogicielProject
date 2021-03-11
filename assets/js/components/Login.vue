<template>
  <v-card class="mx-auto" max-width="344">
    <v-form ref="form" @submit.prevent="loginUser">
      <v-text-field
        v-model="email"
        :rules="emailRules"
        label="E-mail"
        required
      ></v-text-field>

      <v-text-field
        v-model="mdp"
        type="password"
        label="Mot de passe"
        required
      ></v-text-field>

      <v-btn type="submit" color="success" class="mr-4">
        Connexion
      </v-btn>
    </v-form>
  </v-card>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      email: "",
      mdp: "",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
    };
  },
  methods: {
    loginUser() {
      this.$axios
        .post("/login", {
          email: this.email,
          mdp: this.mdp,
        })
        .then((response) => {
          console.log(response);
          let token = response.data.token;
        });
    },
  },
};
</script>

<style scoped>
</style>