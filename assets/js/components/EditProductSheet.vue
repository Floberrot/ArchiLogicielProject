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
          <v-text-field
            v-model = "label"
            :placeholder= vehicle.label
            type="text"
            required
            label="Libellé"
          >
          </v-text-field>
          <v-text-field
            v-model = "brand"
            :placeholder= vehicle.brand
            type="text"
            required
            label="Marque du véhicule"
          >
          </v-text-field>
          <v-text-field
           v-model = "fuel"
            :placeholder= vehicle.fuel
            type="text"
            required
            label="Essence nécessaire"
          >
          </v-text-field>
          <v-text-field
            v-model = "licence"
            :placeholder= vehicle.licence
            type="text"
            required
            label="Permis du véhicule"
          >
          </v-text-field>
          <div v-if="vehicle.type === 'UtilityVehicle'">
          <v-text-field
            v-model = "maxLoad"
            type="number"
            :placeholder= vehicle.max_load
            required
            label="Charge maximum du véhicule"
          >
          </v-text-field>
          <v-text-field
            v-model = "trunkCapacity"
            type="number"
            :placeholder= vehicle.trunk_capacity
            required
            label="Capacité maximum du coffre (en m3)"
          >
          </v-text-field>  
          </div> 
          <div v-if="vehicle.type === 'Motorcycle'">
          <v-checkbox
            :input-value= vehicle.helmetAvailable
            label="Casque disponible avec le véhicule?"
            v-model= "helmetAvailable"
            >
            </v-checkbox>  
          </div>  
          </v-card>     
        </v-col>
        <v-col lg="3">
          <template>
          <v-row justify="space-around">
            <v-card>
            <v-date-picker
              v-model="lastControl"
              color="green lighten-1"
              :value= vehicle.lastControl
            ></v-date-picker>
            <v-divider></v-divider>
            <v-card-title>Dernier controle du véhicule</v-card-title>
            </v-card>
          </v-row>
        </template>
        </v-col>
      </v-row>
      <v-row justify="center" class="customColHeightMiddle mt-16">
        <v-col lg="12">
          <v-textarea 
          v-model ="description" 
          solo 
          name="textarea" 
          :placeholder= vehicle.description
          >
          </v-textarea>
        </v-col>
      </v-row>
      <v-row class="customColHeightBottom">
        <v-col lg="12" class="d-flex justify-end align-content-center">
          <v-switch
            v-model="privacy"
            true-value="Privé"
            false-value="Public"
            :label="`${ privacy }`"
            class="mt-2"
          ></v-switch>
          <v-btn v-on:click="deleteVehicle()" color="error" class="ml-2">Supprimer<v-icon>mdi-trash</v-icon></v-btn>
          <v-btn v-on:click="sendEditField()" color="success" class="ml-2">Valider</v-btn>
        </v-col>
      </v-row>
    </v-col>
    <v-snackbar
      color="success"
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
  </v-row>
</template>

<script>
export default {
  name: "Detail",
  data() {
    return {
      privacy: "Public",
      vehicle: [],
      label: '',
      brand: '',
      licence: '',
      fuel:'',
      type: '',
      maxLoad: '',
      trunkCapacity: '',
      helmetAvailable:'',
      snackbar: false,
      message:'',
      description: '',
      lastControl:'',
      conceptionDate:''
      };
  },

  mounted() {
    this.getVehicleDetailById() //Récupère le véhicul avec son id
  },
  methods: {
    getVehicleDetailById() {
    this.$axios
      .get("/api/vehicle/" + this.$route.params.id)
      .then(response => {
      this.vehicle = response.data['detailVehicle']
      // Récupère et set les données de data qu'on reçoit du controller php
      this.type = this.vehicle.type
      this.label = this.vehicle.label
      this.brand = this.vehicle.brand
      this.licence = this.vehicle.licence
      this.fuel = this.vehicle.fuel
      this.description = this.vehicle.description
      this.maxLoad = this.vehicle.max_load
      this.trunkCapacity = this.vehicle.trunk_capacity
      this.helmetAvailable = this.vehicle.helmet_available
      this.lastControl = this.vehicle.last_control
      this.conceptionDate = this.vehicle.conception_date
    })
    },
    sendEditField () {
       this.$axios
        .put('api/vehicle/' + this.$route.params.id, {
            resultType: this.type,
            resultLabel: this.label,
            resultBrand: this.brand,
            resultFuel: this.fuel,
            resultLastControl: this.lastControl,
            resultConceptionDate: this.conceptionDate,
            resultDescription: this.description,
            resultLicence: this.licence,
            resultMaxLoad: this.maxLoad,
            resultTrunkCapacity: this.trunkCapacity,
            resultHelmetAvailable: this.helmetAvailable,
        })
        .then((response) => {
            this.snackbar = true
            this.message = response.data.message
        })
    },
    deleteVehicle() {
      if(confirm('Vous êtes sur ?')) {
        this.$axios
        .delete('api/vehicle/' + this.$route.params.id)
        .then((response) => {
          this.snackbar = true
          this.message = response.data.message
          setTimeout(2000, this.$router.push({ path: '/' })  )
        })
      }
    }
  }
}
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
</style>