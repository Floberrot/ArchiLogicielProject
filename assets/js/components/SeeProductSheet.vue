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
          <p>{{ vehicle.label }}</p>
          <p>Marque : {{ vehicle.brand }}</p>
          <p>Dernier contrôle technique : {{ vehicle.last_control }}</p>
        </v-col>
      </v-row>
      <v-row justify="center" class="customColHeightMiddle">
        <v-col lg="12">
          <v-textarea solo name="textarea" label="Solo textarea"></v-textarea>
        </v-col>
      </v-row>
      <v-row class="customColHeightBottom">
        <v-col lg="12" class="d-flex justify-end">
          <v-btn color="primary">Editer</v-btn>
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
</style>