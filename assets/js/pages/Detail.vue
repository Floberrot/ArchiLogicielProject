<template>
  <v-row justify="center" d-flex align-center mt-6>
    <v-col cols="12">
      <v-btn plain icon class="py-7" @click="redirectHome">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-sheet
        color="white"
        elevation="1"
        height="80vh"
        rounded
        width="100%">
        <see-product-sheet v-if="displayDetail"/>
        <edit-product-sheet v-if="displayEdit"/>
      </v-sheet>
    </v-col>
  </v-row>
</template>

<script>
import SeeProductSheet from '../components/SeeProductSheet'
import EditProductSheet from '../components/EditProductSheet'
export default {
  name: "Detail",
  components: {
    SeeProductSheet,
    EditProductSheet,
  },
  data() {
    return {
      displayDetail: false,
      displayEdit: false
    };
  },
  created () {
    if(this.$route.name == "edit"){
      this.displayEdit = true
    } else {
      this.displayDetail = true
    }
  },
  methods: {
    redirectHome () {
      this.$router.push('/');
    }
  }
};
</script>

<style scoped>
html {
  overflow-y: hidden !important;
}
</style>