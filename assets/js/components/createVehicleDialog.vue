<template>
  <v-row justify="center">
    <v-form
      ref="form"
      v-model="valid"
      lazy-validation
      >
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
                v-model="type"
                  :items="['Moto', 'Véhicule utilitaire']"
                  label="Type de véhicule"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                v-model="label"
                  label="Libellé"
                  :rules="[rules.required]"
                  hint="Ex: Véhicule du commercial"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field 
                v-model="brand"
                 label="Marque"
                 :rules="[rules.required]"
                 hint="Ex: BMW"
                 required
                 >
                 </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-menu max-width="290">
                  <template v-slot:activator="{ on }">
                    <v-text-field 
                    :value=conceptionDate 
                    slot="activator" 
                    label="Année de conception du véhicule" 
                    required 
                    v-on="on"
                    :rules="[rules.required]"
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="conceptionDate" ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6">
                <v-menu max-width="290">
                  <template v-slot:activator="{ on }">
                    <v-text-field 
                    :value=lastControl 
                    slot="activator" 
                    label="Dernier contrôle technique" 
                    required 
                    v-on="on"
                    :rules="[rules.required]"
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="lastControl"></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select
                v-model="fuel"
                  :items="['Aucun', 'Essence', 'Diesel']"
                  label="Carburant"
                  :rules="[rules.required]"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field
                v-model="licence"
                  label="Permis"
                  :rules="[rules.required]"
                  hint="Ex : Permis B"
                  required
                ></v-text-field>
                <v-checkbox
                input-value='false'
                label="Casque disponible avec le véhicule ?"
                v-model= "helmetAvailable"
                v-if="type === 'Moto'"
                >
                </v-checkbox> 
                <v-text-field
                v-model="maxLoad"
                  label="Charges maximum (en kg)"
                  v-if="type === 'Véhicule utilitaire'"
                ></v-text-field>
                <v-text-field
                v-model="trunkCapacity"
                  label="Capacité du coffre (en m3)"
                  v-if="type === 'Véhicule utilitaire'"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*Obligatoire</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" text @click="hide()"> Annuler </v-btn>
          <v-btn :disabled="!valid" color="green darken-1" text @click="createVehicle()"> Sauvegarder </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-form>
  </v-row>
</template>

<script>
export default {
  name: "createVehicleDialog",
  data() {
    return {
      rules: {
          required: value => !!value || 'Ce champ est requis',
      },
      valid: true,
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
      if (this.type === 'Véhicule utilitaire') { this.type = 'UtilityVehicle'}
      if (this.type === 'Moto') { this.type = 'Motorcycle'}
      this.$axios
        .post("/api/vehicle", {
          resultType: this.type,
          resultLabel: this.label,
          resultBrand: this.brand,
          resultFuel: this.fuel,
          resultLicence: this.licence,
          resultLastControl: this.lastControl,
          resultConceptionDate: this.conceptionDate,
          resultHelmetAvailable: this.helmetAvailable,
          resultMaxLoad: this.maxLoad,
          resultTrunkCapacity: this.trunkCapacity,
          resultDescription: 'A remplir'
        })
        .then((response) => {
          this.dialog = false;
        }).catch((error) => {
          console.log(error)
        });
    },
  },
};
</script>