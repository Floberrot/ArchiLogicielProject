<template>
  <v-row justify="center" class="customHeight100">
    <v-col lg="10" class="customHeight100">
      <v-row justify="center" class="customColHeightTop">
        <v-col lg="6" class="customHeight100">
          <v-img
              max-height="100%"
              max-width="100%"
              src="https://picsum.photos/id/514/1000/800?blur=2"
          ></v-img>
        </v-col>
        <v-col lg="3">
          <v-card class="pa-3">
            <v-card-title
            >
              Informations du véhicule
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text
                label="Marque du véhicule"
            >
              Label : <strong>{{ vehicle.label }}</strong>
            </v-card-text>
            <v-card-text
                label="Marque du véhicule"
            >
              Marque : <strong>{{ vehicle.brand }}</strong>
            </v-card-text>
            <v-card-text
                label="Marque du véhicule"
            >
              Essence : <strong>{{ vehicle.fuel }}</strong>
            </v-card-text>
            <v-card-text
                label="Marque du véhicule"
            >
              Permis : <strong>{{ vehicle.licence }}</strong>
            </v-card-text>
            <v-card-text
                label="Marque du véhicule"
            >
              Date de conception : <strong>{{ vehicle.conception_date }}</strong>
            </v-card-text>
            <v-card-text
                label="Marque du véhicule"
            >
              Dernier contrôle : <strong>{{ vehicle.last_control }}</strong>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col
            lg="3"
            v-if="vehicle.type !== ''">
          <v-card>
            <v-card-title>
              Informations complémentaire
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text
                label="Marque du véhicule"
                v-if="vehicle.type === 'Motorcycle'"
            >
              Casque disponible avec le véhicule : <strong>{{ this.valueHelmet }}</strong>
            </v-card-text>
            <v-card-text
                label="Marque du véhicule"
                v-if="vehicle.type === 'UtilityVehicle'"
            >
              Charge maximum du véhicule : <strong>{{ vehicle.max_load }} kg</strong>
            </v-card-text>
            <v-card-text
                label="Marque du véhicule"
                v-if="vehicle.type === 'UtilityVehicle'"
            >
              Capacité maximum du coffre : <strong>{{ vehicle.trunk_capacity }}</strong>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row justify="center" class="customColHeightMiddle">
        <v-col lg="12">
          <v-textarea readonly solo name="textarea" class="pt-5" label="Solo textarea"
                      v-model="vehicle.label"></v-textarea>
        </v-col>
      </v-row>
      <v-row v-if="role !== 'Membre'" class="customColHeightBottom">
        <v-col lg="12" class="d-flex justify-end">
          <v-btn color="primary" @click="redirectEdit">Editer</v-btn>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "Detail",
  data() {
    return {
      vehicle: '',
      role: '',
      valueHelmet: '',
    };
  },
  created() {
    this.checkRoleOfUser()
  },
  mounted() {
    this.listVehicleRequest() //Récupère les véhicules
  },
  methods: {
    listVehicleRequest() {
      this.$axios.get("/api/vehicle/" + this.$route.params.id)
          .then(response => {
            console.log(response)
            this.vehicle = response.data["detailVehicle"]
            if (this.vehicle.helmet_available === true) {
              this.valueHelmet = 'Oui'
            } else {
              this.valueHelmet = 'Non'
            }
          })
    },
    checkRoleOfUser() {
      let token = window.localStorage.getItem('token')
      this.$axios.post("/admin/role/user", {
        token: token
      })
          .then(response => {
            this.role = response.data.role
            console.log(this.role)
          })
    },
    redirectEdit() {
      this.$router.go(this.$router.push({name: 'edit', params: {id: this.$route.params.id}}))
    }
  }
};
</script>

<style scoped>
.customHeight100 {
  height: 100%
}

.customColHeightTop {
  height: 60%;
}

.customColHeightMiddle {
  height: 30%;
}

.customColHeightBottom {
  height: 10%;
}

.alignEnd {
  text-align: end;
}
</style>