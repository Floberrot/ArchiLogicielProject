<template>
  <v-form ref="form" @submit.prevent="checkValid">
    <v-container class="py-0">
      <v-row justify="center">
        <v-col cols="10">
          <v-text-field
            v-model="email"
            :rules="[rules.required, rules.email]"
            label="E-mail"
            required
          ></v-text-field>

          <v-text-field
            v-model="mdp"
            :rules="[rules.required]"
            type="password"
            label="Password"
            required
          ></v-text-field>

          <v-text-field
            v-model="mdp2"
            :rules="[rules.required]"
            type="password"
            label="Confirmer le mot de passe"
          ></v-text-field>

          <v-btn type="submit" color="success" class="mr-4">
            Inscription
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-snackbar
      :color="color"
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
  name: "RegisterForm",
  data() {
    return {
      email: "",
      mdp: "",
      mdp2: "",
      rules: {
          required: value => !!value || 'Ce champ est requis',
          email: value => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalide'
          },
      },
      snackbar: false,
      timeout: 3000,
      message: "",
      color: "",
    };
  },
  methods: {
    checkValid() {
      if (this.mdp !== this.mdp2){
        this.snackbar = true
        this.message = "Les mots de passe doivent être identiques"
      } else if(!this.$refs.form.validate()){
        this.snackbar = true
        this.message = "Erreur de saisi"
        this.color = "red"
      } else {
        this.registerUser()
      }
    },
    registerUser() {
      this.$axios
        .post("/register", {
          email: this.email,
          mdp: this.mdp,
        })
        .then((response) => {
          if (!response.data.RegistrationOK) {
            this.snackbar = true
            this.message = "Un utilisateur avec cette adresse mail existe déjà"
          } else {
            this.snackbar = true
            this.message = "Vous êtes désormais inscrit"
            this.color = "green"
            this.$router.go()
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