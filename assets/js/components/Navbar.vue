<template>
  <v-app-bar
    v-if="display"
    app
    absolute
    fixed
    color="white"
    flat
    class="zIndex"
  >
    <v-app-bar-nav-icon
      @click="OpenDrawer()"
    >
    </v-app-bar-nav-icon>

    <v-toolbar-title>Vos véhicules</v-toolbar-title>

    <v-spacer></v-spacer>
    <drawer
      ref="drawer"
      v-click-outside="onClickOutside"
    />
  </v-app-bar>
</template>

<script>
import Drawer from './Drawer'
export default {
  name: "Navbar",
  components: {
    Drawer,
  },
  data () {
      return {
        display: true,
        items: [
          { title: 'Home', icon: 'mdi-view-dashboard' },
          { title: 'About', icon: 'mdi-forum' },
        ],
      }
  },
  mounted () {
    if (localStorage.getItem('token')) {
      this.display = true
    } else {
      this.display = false
    }
  },
  methods: {
    onClickOutside () {
      this.$refs.drawer.hide()
    },
    OpenDrawer () {
      this.$refs.drawer.show()
    }
  },
}
</script>

<style scoped>
.zIndex {
  z-index: 10!important;
}
</style>