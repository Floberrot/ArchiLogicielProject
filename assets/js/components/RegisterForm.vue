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
        .post("/login", {
          email: this.email,
          mdp: this.mdp,
        })
        .then((response) => {
          console.log(response);
          if (!response.data.isValid) {
            this.snackbar = true
            this.message = "Email or Password is wrong"
          } else {
            let token = response.data.token;
            let role = response.data.role;
            localStorage.setItem('role', JSON.stringify(role));
            localStorage.setItem('token', JSON.stringify(token));
            this.$router.push('/')
          }
        }).catch((error) => {
          console.log(error)
        });
    },
  },
};
</script>

<style scoped>
</style>