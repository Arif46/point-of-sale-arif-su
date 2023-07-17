<template>
  <div class="main-wrapper" :class="{ closeSidebar: closeSidebar}">
    <div class="sidebar-section sidebarHide desktop-hidden d-none d-md-block">
      <Sidebar :layout="'designer'"></Sidebar>
    </div>
    <div class="main-content-section containerFullWidth">
      <Header :layout="'designer'"></Header>
      <div class="main-content-wrapper">
        <router-view></router-view>
      </div>
      <Footer></Footer>
    </div>
  </div>
</template>
<script>
import Sidebar from '../components/Sidebar.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import { EventBus } from '@/EventBusLayout'
export default {
  name: 'MainLayout',
  data () {
    return {
      closeSidebar: false
    }
  },
  created () {
    EventBus.$on('toggleNav', this.checkSidebarToggleValue)
  },
  components: {
    Sidebar,
    Header,
    Footer
  },
  methods: {
    checkSidebarToggleValue (param) {
      this.closeSidebar = param
    }
  }
}
</script>
