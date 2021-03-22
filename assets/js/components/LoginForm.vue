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
          color="white"
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
      timeout: 3000,
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
            this.message = "E-mail ou mot de passe érroné"
          } else {
            if (!response.data.isAuthorized) {
              this.snackbar = true
              this.message = "Votre demande est en attente"
            } else {
              let token = response.data.token;
              let role = response.data.role;
              localStorage.setItem('role', JSON.stringify(role));
              localStorage.setItem('token', JSON.stringify(token));
              this.$router.push('/')
            }
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