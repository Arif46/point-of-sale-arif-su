<template>
  <div class="main-wrapper" :class="{ closeSidebar: closeSidebar}">
    <div class="sidebar-section sidebarHide desktop-hidden d-none d-md-block">
      <Sidebar :layout="'designer'"></Sidebar>
    </div>
    <div class="main-content-section containerFullWidth">
      <div class="section-wrapper">
        <Header :layout="'designer'"></Header>
        <div class="main-content-wrapper">
          <router-view></router-view>
        </div>
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
import commonServiceMixin from '@/mixins/common-service'
import { mapActions } from 'vuex'
export default {
  name: 'MainLayout',
  mixins: [commonServiceMixin],
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
  computed: {
    currentLocale () {
      return this.$i18n.locale
    }
  },
  watch: {
    currentLocale: function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.localizeCommonDropdownCommonService({ value: newVal })
      }
    }
  },
  methods: {
    checkSidebarToggleValue (param) {
      this.closeSidebar = param
    },
    ...mapActions({
      localizeCommonDropdownCommonService: 'CommonService/localizeDropdown'
    })
  }
}
</script>
