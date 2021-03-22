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
          <v-text-field
            v-model="label"
            type="text"
            label="Label"
            required
          >
          </v-text-field>
          <v-text-field
            v-model="label"
            type="text"
            label="Label"
            required
          >
          </v-text-field>
          <v-text-field
            v-model="label"
            type="text"
            label="Label"
            required
          >
          </v-text-field>
        </v-col>
      </v-row>
      <v-row justify="center" class="customColHeightMiddle">
        <v-col lg="12">
          <v-textarea solo name="textarea" label="Solo textarea"></v-textarea>
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
          <v-btn color="error" class="ml-2">Supprimer<v-icon>mdi-trash</v-icon></v-btn>
          <v-btn color="success" class="ml-2">Valider</v-btn>
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
      privacy: "Public",
    };
  },
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