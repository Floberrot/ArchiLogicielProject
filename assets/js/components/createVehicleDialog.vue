<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Ajouter un véhicule</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="['Motorcyle', 'UtilityVehicle', '30-54', '54+']"
                  label="type"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Label"
                  hint="Ex :Véhicule du commercial"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field label="Marque" required></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="Année de construction"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-menu max-width="290">
                  <template v-slot:activator="{ on }">
                    <v-text-field :value="date" slot="activator" label="Dernier contrôle technique" v-on="on"></v-text-field>
                  </template>
                  <v-date-picker v-model="date"></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select
                  :items="['Aucun', 'Essence', 'Diesel']"
                  label="Carburant"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field
                  label="Permis"
                  hint="Ex : Permis B"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*Obligatoire</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="hide()"> Annuler </v-btn>
          <v-btn color="blue darken-1" text @click="createVehicle()"> Sauvegarder </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  name: "createVehicleDialog",
  data() {
    return {
      dialog: false,
      type:'',
      label: '',
      brand: '',
      conceptionDate:'',
      lastControl: '',
      fuel: '',
      licence: '',
      helmetAvailable: '',
      maxLoad: '',
      trunkCapacity: '',
      // date: new Date().toISOString().substr(0, 10),
    };
  },
  mounted() {
    
  },
  methods: {
    show() {
      this.dialog = true;
    },
    hide() {
      this.dialog = false;
    },
    createVehicle() {
      this.$axios
        .post("/api/vehicle", {
          email: this.email,
          mdp: this.mdp,
        })
        .then((response) => {
          console.log(response);
            let token = response.data.token;
            let role = response.data.role;
            localStorage.setItem('role', JSON.stringify(role));
            localStorage.setItem('token', JSON.stringify(token));
            this.$router.push('/')
        }).catch((error) => {
          console.log(error)
        });
    },
  },
};
</script>