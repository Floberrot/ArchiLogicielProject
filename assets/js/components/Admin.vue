<template>
  <v-app-bar
    app
    absolute
    fixed
    color="white"
  >
    <v-card class="mx-auto" width="400" max-width="400" tile>
    <ul>
      <li v-for="user in userData" class="listUser">
        <div class="text-center listUserContent">
          <p>{{ user.email }}</p>
          <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="red lighten-2" dark v-bind="attrs" v-on="on">Voir la demande</v-btn>
            </template>
            <!--  Modal  -->
            <v-card>
              <!-- Titre de la card -->
              <v-card-title class="headline grey lighten-2">Demande d'enregistrement</v-card-title>

              <form @submit.prevent="AuthorizeUser" method="post">
                <!-- Contenu de la card -->
                <v-card-text class="d-flex">
                  <p> Nouvel utilisateur : {{ user.email }}</p>
                  <!--Select des rôles -->
                  <v-select :items="rolesOptions" filled label="Attribuer un rôle" name="role"></v-select>
                  <v-select :items="authorizeOptions" filled label="Autoriser ?" name="isAuthorize"></v-select>
                  <v-btn hidden :value="user.id" name="id"></v-btn>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn type="submit" color="green lighten-2" dark v-on:click="dialog = false">Enregistrer</v-btn>
                </v-card-actions>
              </form>
            </v-card>
            <!--  Modal  -->
          </v-dialog>
        </div>

      </li>
    </ul>
    </v-card>
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
  created() {
    this.listUserRequest() //Execute la fonction à la création de la page
  },
  methods: {
    AuthorizeUser(submitEvent) {
      //Récupération des données du formulaire
      this.role = submitEvent.target.elements.role.value
      this.authorize = submitEvent.target.elements.isAuthorize.value
      this.authorize === "Oui" ? this.authorize = true : this.authorize = false
      this.id = submitEvent.target.elements.id.value

      this.$axios.post(`/admin/authorize/${this.id}`,{
          isAuthorize: this.authorize,
          role: this.role
      })
      .then(response => {
        this.listUserRequest()// On re actualise la liste en rappelant la fonction
      })
      // .catch(error => {
      //   console.log(error.data)
      // });
    },
    // Permet de lister les utilisateur qui ce sont enregistrés
    listUserRequest () {
      this.$axios.get("/admin/getUserRequest")
          .then(response => {
            this.userData = response.data["allNewUser"]
          })
          // .catch(error => {
          //
          // });
    },
  },
  name: "Admin"
}
</script>

<style scoped>
.listUser{
  list-style-type: none;
}
.listUserContent{
  display: flex;
}
.listUserContent p{
  margin-right: 1em;
}
</style>