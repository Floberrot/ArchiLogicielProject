<template>
  <v-row justify="center">
    <v-col lg="10">
      <v-row justify="center">
        <v-col lg="6">
          <v-img
            max-height="250"
            max-width="350"
            src="https://picsum.photos/id/11/200/100"
          ></v-img>
        </v-col>
        <v-col lg="6">
          <p>Text</p>
          <p>Text</p>
          <p>Text</p>
        </v-col>
      </v-row>
      <v-row justify="center">
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
</style>