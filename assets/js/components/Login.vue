<template>
  <div class="card">
    <form action="" @submit.prevent="loginUser">
      <div class="form-group">
        <input type="text" v-model="email" class="form-control" placeholder="email">
        <input type="password" v-model="mdp" class="form-control" placeholder="mdp">
        <button type="submit">Connecter</button>
      </div>
    </form>
    <v-card
    class="mx-auto"
    max-width="344"
  >
    <v-card-text>
      <div>Word of the Day</div>
      <p class="display-1 text--primary">
        el·ee·mos·y·nar·y
      </p>
      <p>adjective</p>
      <div class="text--primary">
        relating to or dependent on charity; charitable.<br>
        "an eleemosynary educational institution."
      </div>
    </v-card-text>
    <v-card-actions>
      <v-btn
        text
        color="teal accent-4"
        @click="reveal = true"
      >
        Learn More
      </v-btn>
    </v-card-actions>

    <v-expand-transition>
      <v-card
        v-if="reveal"
        class="transition-fast-in-fast-out v-card--reveal"
        style="height: 100%;"
      >
        <v-card-text class="pb-0">
          <p class="display-1 text--primary">
            Origin
          </p>
          <p>late 16th century (as a noun denoting a place where alms were distributed): from medieval Latin eleemosynarius, from late Latin eleemosyna ‘alms’, from Greek eleēmosunē ‘compassion’ </p>
        </v-card-text>
        <v-card-actions class="pt-0">
          <v-btn
            text
            color="teal accent-4"
            @click="reveal = false"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-expand-transition>
  </v-card>
  </div>
</template>

<script>

  export default {
    name: "Login",
    data() {
      return{
        email: '',
        mdp: '',
      }
    },
    methods: {
      loginUser() {
        this.$axios
          .post('login', {
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