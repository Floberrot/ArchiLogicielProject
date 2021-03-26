<template>
    <v-card class="mx-auto" tile>
      <!-- Affiche un message error -->
      <v-snackbar v-model="snackbar"  rounded="pill" color="error" v-if="this.errorMessage">{{ this.errorMessage }}
      <template v-slot:action="{ attrs }">
        <v-btn id="closeText" color="pink" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
      </v-snackbar>
      <!-- Affiche un message success -->
      <v-snackbar v-model="snackbar"  rounded="pill" color="success" v-else-if="this.successMessage">{{ this.successMessage }}
      <template v-slot:action="{ attrs }">
        <v-btn id="closeText" color="pink" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
      </v-snackbar>
      <!-- Tableau des demande utilisateurs -->
      <v-simple-table width="400">
        <template v-slot:default>
          <thead>
          <tr>
            <th class="text-left">Email</th>
            <th class="text-left">Voir plus</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="user in userData">
            <td>{{ user.email }}</td>
            <td> <v-btn color="red lighten-2" dark v-on:click="OpenDialog(user)">Voir plus</v-btn></td>
          </tr>
          </tbody>
          </template>
      </v-simple-table>

          <!--  Modal  -->
          <v-dialog v-model="dialog" width="500">
            <v-card>
              <!-- Titre de la card -->
              <v-card-title class="headline grey lighten-2">Demande d'enregistrement</v-card-title>

              <form @submit.prevent="AuthorizeUser" method="post">
                <!-- Contenu de la card -->
                <v-card-text>
                  <p><span class="font-weight-bold">Nouvel utilisateur :</span> {{ selectedUserInfo.email }}</p>
                  <!--Select des rôles -->
                  <v-select ref="rolesOptions" :items="rolesOptions" filled label="Attribuer un rôle" name="role"></v-select>
                  <v-select ref="authorizeOptions" :items="authorizeOptions" filled label="Accepter la demande" name="isAuthorize"></v-select>
                  <v-btn hidden :value="selectedUserInfo.id" name="id"></v-btn>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn type="submit" color="green lighten-2" dark>Enregistrer</v-btn>
                </v-card-actions>
              </form>
            </v-card>
          </v-dialog>
          <!--  Modal  -->
    </v-card>
</template>

<script>
export default {
  data() {
    return {
      userData: [],
      selectedUserInfo: [],
      dialog: false,
      snackbar: false,
      rolesOptions: ['Member', 'Manager'],
      authorizeOptions: ['Oui', 'Non'],
      errorMessage: null,
      successMessage: null
    }
  },
  mounted() {
    this.listUserRequest() // Execute la fonction à la création de la page
  },
  methods: {
    // Ouvre la modal avec les informations de l'utisateur
    OpenDialog(userInfo){
      this.selectedUserInfo = userInfo
      this.dialog = true
      this.clearOptionsSelected();
    },
    // Réinitialise les options des selects
    clearOptionsSelected() {
      if (this.$refs['rolesOptions'] || this.$refs['authorizeOptions']) {
        this.$refs['rolesOptions'].reset();
        this.$refs['authorizeOptions'].reset();
      }
    },
    // Gestion de l'autorisation d'un utilisateur
    AuthorizeUser(submitEvent) {
      // Récupération des données du formulaire
      this.role = submitEvent.target.elements.role.value
      this.authorize = submitEvent.target.elements.isAuthorize.value
      this.id = submitEvent.target.elements.id.value
      //Si les deux select sont séléctionnés
      if(this.role && this.authorize) {
        if(this.authorize != "Oui") {
          //Si le manager clique sur "Non"
          this.errorMessage = "Utilisateur refusé"
          this.snackbar = true
          this.dialog = false
          this.successMessage = null
        } else {
          this.authorize === "Oui" ? this.authorize = true : this.authorize = false
          this.errorMessage = null
          this.successMessage = "Utilisateur autorisé"
          this.snackbar = true
          this.dialog = false
          // On set les données
          this.$axios.post(`/admin/authorize/${this.id}`,{
              isAuthorize: this.authorize,
              role: this.role
          })
          .then(response => {
            // On re actualise la liste en rappelant la fonction
            this.listUserRequest()
          })
        }
      } else {
        //Sinon on affiche une erreur
        this.snackbar = true
        this.dialog = true
        this.successMessage = null
        this.errorMessage = "Veuillez remplir tous les champs"
      }
      
    },
    // Permet de lister les utilisateurs qui ce sont enregistrés
    listUserRequest () {
      this.$axios.get("/admin/get/user")
          .then(response => {
            this.userData = response.data["allNewUser"]
          })
    },
  },
  name: "Admin"
}
</script>

<style scoped>
#closeText{
  color: #fff !important;
}
</style>