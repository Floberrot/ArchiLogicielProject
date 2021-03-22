<template>
  <v-container class="customCenter">
    <v-card rounded>
      <v-card-text class="card" align="center" justify="center">
          <login-form v-if="isLogin" />
          <register-form v-if="!isLogin" />
          <a class="d-flex justify-space-around mb-6" @click="switchForm()">
            {{ btnTitle }}
          </a>
      </v-card-text>
    </v-card>
  </v-container>
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
  beforeCreate() {
    if(window.localStorage.getItem('token') !== null) {
      this.$router.push({ path: '/' })    
      }
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
.customCenter {
  position: absolute;
  overflow: hidden;

  height: 80vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.card{
  width: 40vw;
}
</style>