import RestApi, { apiBaseUrl } from '@/config/api_config'

export default {
  computed: {
    hasDropdownLoadedCommonService () {
      return this.$store.state.CommonService.commonObj.hasDropdownLoaded
    }
  },
  watch: {
    hasDropdownLoadedCommonService: function (newValue) {
      if (!newValue) {
        this.loadCommonDropdown()
      }
    }
  },
  created () {
    this.loadCommonDropdown()
  },
  methods: {
    loadCommonDropdown () {
      RestApi.getData(apiBaseUrl, 'common-dropdowns', null).then(response => {
        if (response.success) {
          this.$store.dispatch('CommonService/mutateCommonObj', {
            hasDropdownLoaded: true,
            divisionList: response.data.divisionList,
            districtList: response.data.districtList,
            upazilaList: response.data.upazilaList,
            unionList: response.data.unionList,
            cityCorporationList: response.data.cityCorporationList,
            paurashavaList: response.data.paurashavaList,
            shopList: response.data.shopList,
            roleList: response.data.roleList,
            categoryList: response.data.categoryList,
            brandList: response.data.brandList,
            colorList: response.data.colorList,
            modelList: response.data.modelList,
            bankList: response.data.bankList,
            branchList: response.data.branchList,
            wardList: response.data.wardList

          })
          this.$store.dispatch('CommonService/localizeDropdown', { value: this.$i18n.locale })
        }
      })
    }
  }
}
