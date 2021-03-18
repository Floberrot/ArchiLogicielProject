<template>
  <v-row justify="center" class="customHeight100">
    <v-col lg="10">
      <v-row justify="center" class="customColHeight">
        <v-col lg="6" class="customHeight100">
          <v-img
            max-height="100%"
            max-width="100%"
            src="https://picsum.photos/id/514/1000/800?blur=2"
          ></v-img>
        </v-col>
        <v-col lg="6">
          <p>Text</p>
          <p>Text</p>
          <p>Text</p>
        </v-col>
      </v-row>
      <v-row justify="center" class="customColHeight">
        <v-col lg="12">
          <v-textarea solo name="textarea" label="Solo textarea"></v-textarea>
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
      
    };
  },
};
</script>

<style scoped>
.customHeight100 {
  height: 100%
}
.customColHeight {
  height: 50%;
}
</style>