<template>
  <v-app-bar
    app
    absolute
    fixed
    color="white"
  >
  <div>
    <ul>
      <li v-for="user in userData">
        <!--  Modal  -->
        <div class="text-center">
          <p> {{ user.email }}</p>
          <v-dialog
              v-model="dialog"
              width="500"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="red lighten-2" dark v-bind="attrs" v-on="on">
                Click Me
              </v-btn>
            </template>

            <v-card>
              <!-- Titre de la card -->
              <v-card-title class="headline grey lighten-2">
               Demande d'enregistrement
              </v-card-title>

              <form @submit.prevent="testAuthorize" method="post">
                <!-- Contenu de la card -->
                <v-card-text class="d-flex">
                  <p> {{ user.email }}</p>
                  <!--Select des rôles -->
                  <v-select :items="rolesOptions" filled label="Attribuer un rôle" name="role"></v-select>
                  <v-select :items="authorizeOptions" filled label="Autoriser ?" name="isAuthorize"></v-select>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn type="submit" color="green lighten-2" dark v-on:click="dialog = false">
                    Enregistrer
                  </v-btn>
                </v-card-actions>
              </form>

            </v-card>
          </v-dialog>
        </div>
        <!--  Modal  -->
      </li>
    </ul>
  </div>
  </v-app-bar>
</template>

<script>
export default {
  data() {
    return {
      userData: [],
      dialog: false,
      rolesOptions: ['Member', 'Manager'],
      authorizeOptions: ['Oui', 'Non'],
    }
  },
  mounted() {
    this.listUserRequest();
  },
  methods: {
    testAuthorize (submitEvent) {
      this.role = submitEvent.target.elements.role.value
      this.authorize = submitEvent.target.elements.isAuthorize.value
      console.log(this.role)
      console.log(this.authorize)
      // this.$axios.post("/admin/authorize/1",{
      //     isAuthorize: true,
      //     role: 'Membre'
      // })
    },
    listUserRequest () {
      this.$axios.get("/admin/getUserRequest")
          .then(response => {
            this.userData = response.data["allNewUser"]
          })
          .catch(error => {

          });
    },
  },
  name: "Admin"
}
</script>

<style scoped>

</style>