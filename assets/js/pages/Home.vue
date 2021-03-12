<template>
  <v-row justify="center">
    <v-col cols="12">
      <v-btn icon>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-simple-table fixed-header height="80vh">
        <thead>
          <tr>
            <th class="text-left">
              <strong>Label</strong>
            </th>
            <th class="text-left">
              Brand
            </th>
            <th class="text-left">
              Modifier
            </th>
            <th class="text-left">
              Voir
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in vehicles"
            :key="item.label"
          >
            <td><strong>{{ item.label }}</strong></td>
            <td>{{ item.brand }}</td>
            <td>
              <v-btn icon>
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
            </td>
            <td>
              <v-btn icon>
                <v-icon>mdi-eye</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </v-simple-table>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "Home",
  data() {
    return {
      vehicles: [
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
          {
            label: '206',
            brand: 'Peugeot',
          },
          {
            label: 'Clio',
            brand: 'Renault',
          },
      ],
    };
  },
};
</script>

<style scoped>
</style>