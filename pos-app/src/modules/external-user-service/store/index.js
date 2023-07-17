import actions from './actions'
import getters from './getters'
import { mutations } from './mutations'
import custom from './custom'

const state = {
  isInsidePanel: false,
  externalPanels: [],
  externalMenus: [],
  cipPanel: {
    commonObj: {
      hasDropdownLoaded: false,
      // circularList: [],
      exportSectorList: [],
      venueList: [],
      circular: null
    },
    cipAppTypeList: custom.cipAppTypeList,
    latentExporterList: custom.latentExporterList,
    orgTypeList: custom.orgTypeList,
    merchandisingTypeList: custom.merchandisingTypeList
  },
  bftiPanel: {
    commonObj: {
      hasDropdownLoaded: false,
      // circularList: [],
      exportSectorList: []
    }
  },
  dealerPanel: {
    commonObj: {
      hasDropdownLoaded: false,
      paymentTypeList: custom.paymentTypeList
    }
  }
}

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
}
