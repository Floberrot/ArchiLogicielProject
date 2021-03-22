<template>
  <v-slide-x-transition>
    <v-card v-if="drawer" height="100vh" width="20%" class="mx-auto editDrawer">
      <v-navigation-drawer width="100%">
        <v-list dense nav>
          <v-list-item-icon>
            <v-btn plain icon @click="hide()">
              <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
          </v-list-item-icon>
          <v-list-item v-for="item in items" :key="item.title" link @click="redirect(item.path)">
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title :class="item.class">{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </v-card>
  </v-slide-x-transition>
</template>

<script>
export default {
  data() {
    return {
      items: [
        { title: "Mes véhicules", icon: "mdi-car", path: "/"},
        { title: "Gestion d'utilisateurs (soon)", icon: "mdi-account", class: 'text--disabled', path: 'usermanager' },
      ],
      drawer: false,
    };
  },
  methods: {
    hide () {
      this.drawer = false;
    },
    show () {
      this.drawer = true;
    },
    redirect (path) {
      this.$router.push(path);
    }
  },
};
</script>

<style scoped>
.editDrawer {
  position: absolute;
  top: 0;
  left: 0;
}
</style>