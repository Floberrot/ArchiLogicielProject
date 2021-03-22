<template>
  <v-form ref="form" @submit.prevent="registerUser">
    <v-container class="py-0">
      <v-row justify="center">
        <v-col cols="10">
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
          ></v-text-field>

          <v-text-field
            v-model="mdp"
            type="password"
            label="Password"
            required
          ></v-text-field>

          <v-text-field
            v-model="mdp2"
            type="password"
            label="Confirmer le mot de passe"
          ></v-text-field>

          <v-btn type="submit" color="success" class="mr-4">
            Inscription
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
export default {
  name: "RegisterForm",
  data() {
    return {
      email: "",
      mdp: "",
      mdp2: "",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
    };
  },
  methods: {
    registerUser() {
      this.$axios
        .post("/register", {
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