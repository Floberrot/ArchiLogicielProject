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
        <v-col lg="6">
          <v-simple-table dense>
            <template>
              <tbody>
                <tr>
                  <td>Nom</td>
                  <td class="alignEnd">{{ vehicle.label }}</td>
                </tr>
                <tr>
                  <td>Marque</td>
                  <td class="alignEnd">{{ vehicle.brand }}</td>
                </tr>
                <tr>
                  <td>Année de conception</td>
                  <td class="alignEnd">{{ vehicle.conception_date }}</td>
                </tr>
                <tr>
                  <td>Dernier contrôle technique</td>
                  <td class="alignEnd">{{ vehicle.last_control }}</td>
                </tr>
                <tr>
                  <td>Carburant</td>
                  <td class="alignEnd">{{ vehicle.fuel }}</td>
                </tr>
                <tr>
                  <td>Permis</td>
                  <td class="alignEnd">{{ vehicle.licence }}</td>
                </tr>
                <tr>
                  <td>Visibilité</td>
                  <td class="alignEnd">{{ vehicle.is_public ? "Public" : "Private"}}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-col>
      </v-row>
      <v-row justify="center" class="customColHeightMiddle">
        <v-col lg="12">
          <v-textarea readonly solo name="textarea" label="Solo textarea" v-model="vehicle.label"></v-textarea>
        </v-col>
      </v-row>
      <v-row class="customColHeightBottom">
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
      vehicle: null
    };
  },
  mounted() {
    this.listVehicleRequest() //Récupère les véhicules
  },
  methods: {
    listVehicleRequest () {
      this.$axios.get("/api/vehicle/" + this.$route.params.id)
          .then(response => {
            this.vehicle = response.data["detailVehicle"]
            console.log(this.vehicle)
          })
    },
    redirectEdit () {
      this.$router.push({ name: 'edit', params: { id: this.$route.params.id } })
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
.alignEnd{
  text-align: end;
}
</style>