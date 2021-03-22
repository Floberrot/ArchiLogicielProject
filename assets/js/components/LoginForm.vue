<template>
  <v-form ref="form" @submit.prevent="loginUser">
    <v-container class="py-0">
      <v-row
        justify="center"
      >
        <v-col
          cols="10"
        >
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
          >
          </v-text-field>
          <v-text-field
            v-model="mdp"
            type="password"
            label="Mot de passe"
            required
          >
          </v-text-field>
          <v-btn type="submit" color="success" class="mr-4">
            Connexion
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-snackbar
      color="error"
      rounded="pill"
      v-model="snackbar"
      :timeout="timeout"
    >
      {{ message }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="red"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-form>
</template>

<script>
export default {
  name: "LoginForm",
  data() {
    return {
      email: "",
      mdp: "",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      snackbar: false,
      timeout: 2000,
      message: "Test",
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