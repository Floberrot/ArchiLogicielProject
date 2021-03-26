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
          <v-card-title
          class="mx-auto">
            Hello {{this.email}} !
          </v-card-title>
          <v-list-item v-for="item in items" :key="item.title" link @click="redirect(item.path)">
            <v-list-item-icon
            v-if="role !== 'Membre' && item.title === 'Gestion d\'utilisateurs' || item.title === 'Mes véhicules' || item.title === 'Administration' && role === 'Admin'"
            >
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content
            v-if="role !== 'Membre' && item.title === 'Gestion d\'utilisateurs' || item.title === 'Mes véhicules' || item.title === 'Administration' && role === 'Admin'">
              <v-list-item-title :class="item.class">{{ item.title }} {{item.add}}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </v-card>
  </v-slide-x-transition>
</template>

<script>
import Home from './../pages/Home'
  
export default {
  components: {
    Home,
  },
  data() {
    return {
      items: [
        { title: "Mes véhicules", icon: "mdi-car", path: "/"},
        { title: "Gestion d'utilisateurs", icon: "mdi-account",  path: '/user/manager' },
        { title: "Administration", class:'disabled', add: '( soon... )', icon: "mdi-wrench",  path: '/admin' },
      ],
      drawer: false,
      role: '',
      email: ''
    };
  },
  mounted() {
    this.checkRoleOfUser()
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
    },
    checkRoleOfUser() {
      let token = window.localStorage.getItem('token')
      this.$axios.post("/admin/role/user", {
        token: token
      })
        .then(response => {
          this.role = response.data.role
          this.email = response.data.email
        })
    },
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