<template>
  <v-form ref="form" @submit.prevent="checkValid">
    <v-container class="py-0">
      <v-row
        justify="center"
      >
        <v-col
          cols="10"
        >
          <v-text-field
            v-model="email"
            :rules="[rules.required]"
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
      rules: {
          required: value => !!value || 'Ce champ est requis',
      },
      snackbar: false,
      timeout: 3000,
      message: "",
    };
  },
  methods: {
    checkValid() {
      if(!this.$refs.form.validate()){
        this.snackbar = true
        this.message = "Erreur de saisi"
      } else {
        this.loginUser()
      }
    },
    loginUser() {
      this.$axios
        .post("/login", {
          email: this.email,
          mdp: this.mdp,
        })
        .then((response) => {
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