<template>
  <v-card class="mx-auto" max-width="30vw" rounded>
      <v-card-text>
          <login-form v-if="isLogin" />
          <register-form v-if="!isLogin" />
          <a class="d-flex justify-space-around mb-6" @click="switchForm()">
            {{ btnTitle }}
          </a>
      </v-card-text>
  </v-card>
</template>

<script>
import LoginForm from '../components/LoginForm.vue';
import RegisterForm from '../components/RegisterForm.vue';
export default {
  name: "Auth",
  components: {
      LoginForm,
      RegisterForm,
  },
  data() {
    return {
      isLogin: true,
      btnTitle: 'Inscription',
    };
  },
  methods: {
    switchForm () {
        this.isLogin = !this.isLogin
        this.btnTitle = this.isLogin ? 'Inscription' : 'Connexion'
    },
  },
};
</script>

<style scoped>
</style>