<template>
  <v-row justify="center">
    <v-col cols="12 mt-5">
      <v-card
          elevation="10"
      >
        <v-card-title
          >
          Liste des véhicules de la société
        </v-card-title>
      <v-row class="customRow mb-4">
        <v-btn rounded small color="primary" class="ma-2 white--text" @click="openDialog"
               v-if="role !== 'Membre'"
        >
          Ajouter un véhicule
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
      </v-row>
      <v-simple-table fixed-header height="70vh">
        <thead>
        <tr>
          <th class="text-left">
            <strong>Label</strong>
          </th>
          <th class="text-left">
            <strong>Type de véhicule</strong>
          </th>
          <th class="text-left">
            Marque
          </th>
          <th
              class="text-left"
              v-if="role !== 'Membre'"
          >
            Modifier
          </th>
          <th class="text-left">
            Voir
          </th>
          <th class="text-left"
              v-if="role !== 'Membre'">
            Supprimer
          </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in vehicles"
            :key="item.label"
        >
          <td><strong>{{ item.label }}</strong></td>
          <td>{{ item.type }}</td>
          <td>{{ item.brand }}</td>
          <td v-if="role !== 'Membre'">
            <v-btn color="primary" icon @click="redirectEdit(item.id)">
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
          </td>
          <td>
            <v-btn color="primary"icon @click="redirectDetail(item.id)">
              <v-icon>mdi-eye</v-icon>
            </v-btn>
          </td>
          <td v-if="role !== 'Membre'">
            <v-btn color="error" icon @click="deleteVehicle(item.id)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </td>
        </tr>
        </tbody>
      </v-simple-table>
      </v-card>
    </v-col>
    <create-vehicle-dialog
        v-if="dialog"
        ref="dialog"
    />
    <v-snackbar
        v-model="snackbar"
    >
      {{ this.message }}

      <template>
        <v-progress-circular
            indeterminate
            right
            color="red"
        ></v-progress-circular>
      </template>
    </v-snackbar>

    <v-snackbar
        v-model="snackbarDelete"
        color="warning"
    >
      {{ this.message }}

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
  </v-row>
</template>

<script>
import CreateVehicleDialog from '../components/createVehicleDialog.vue';

export default {
  name: "Home",
  components: {
    CreateVehicleDialog,
  },
  data() {
    return {
      vehicles: [],
      dialog: true,
      role: '',
      snackbar: false,
      snackbarDelete: false,
      message: '',
    };
  },
  mounted() {
    this.checkRoleOfUser() // Récupère le role de l'utilisateur pour bloquer l'accès a des fonctionnalités.
    this.listVehicleRequest() //Récupère les véhicules
  },
  methods: {
    listVehicleRequest() {
      this.$axios.get("/api/vehicle")
          .then(response => {
            this.vehicles = response.data["arrayOfVehicles"]
          })
    },
    checkRoleOfUser() {
      let token = window.localStorage.getItem('token')
      if (token === null) {
        this.$router.push({path: ('/login')})
      } else {
        this.$axios.post("/admin/role/user", {
          token: token
        })
            .then(response => {
              this.role = response.data.role
              if (response.data.errorGetToken || response.data.errorUser) {
                this.snackbar = true
                this.message = response.data.message
                setTimeout(() => {
                  this.$router.push({path: ('/login')})
                }, 3000)
              }
            })
      }
    },
    deleteVehicle(id) {
      if(confirm('Vous êtes sur ?')) {
        this.$axios
            .delete('api/vehicle/' + id)
            .then((response) => {
              this.snackbarDelete = true
              this.message = response.data.message
              setTimeout(() => {
                this.$router.go('/')
              }, 3000 )
            })
      }
    },
    redirectDetail(id) {
      this.$router.push({path: `/detail/${id}`});
    },
    redirectEdit(id) {
      this.$router.push({path: `/edit/${id}`});
    },
    openDialog() {
      this.$refs.dialog.show()
    },
  }
};
</script>

<style scoped>
.customWidth {
  width: 100vw;
}

.customRow {
  justify-content: flex-end;
  padding: 0 15px 15px 0;
}

.background {
  background: darkgrey;
}
</style>