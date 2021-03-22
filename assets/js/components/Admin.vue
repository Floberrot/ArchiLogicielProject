<template>
    <v-card class="mx-auto" tile>
      <!-- Affiche une erreur si il y en a une -->
      <div v-if="this.errorMessage">
        <v-alert  dense outlined text type="error">{{ this.errorMessage }}</v-alert>
      </div>
      <v-simple-table>
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
                  <v-btn type="submit" color="green lighten-2" dark v-on:click="dialog = false">Enregistrer</v-btn>
                </v-card-actions>
              </form>
            </v-card>
          </v-dialog>
          <!--  Modal  -->

        </template>
      </v-simple-table>

    </v-card>
</template>

<script>
export default {
  data() {
    return {
      userData: [],
      selectedUserInfo: [],
      dialog: false,
      rolesOptions: ['Member', 'Manager'],
      authorizeOptions: ['Oui', 'Non'],
      errorMessage: null
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
        this.authorize === "Oui" ? this.authorize = true : this.authorize = false
        this.errorMessage = null
        // On set les données
        this.$axios.post(`/admin/authorize/${this.id}`,{
            isAuthorize: this.authorize,
            role: this.role
        })
        .then(response => {
          // On re actualise la liste en rappelant la fonction
          this.listUserRequest()
        })
      } else {
        //Sinon on affiche une erreur
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

</style>