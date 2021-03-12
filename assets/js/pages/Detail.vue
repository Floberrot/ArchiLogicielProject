<template>
  <v-row justify="center" d-flex align-center mt-6>
    <v-col cols="12">
      <v-btn icon>
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-sheet
        color="white"
        elevation="1"
        height="80vh"
        rounded
        width="100%">
        <see-product-sheet />
      </v-sheet>
    </v-col>
  </v-row>
</template>

<script>
import SeeProductSheet from '../components/SeeProductSheet'
// import EditProductSheet from '../components/EditProductSheet'
export default {
  name: "Detail",
  components: {
    SeeProductSheet,
  },
  data() {
    return {
      
    };
  },
};
</script>

<style scoped>
</style>