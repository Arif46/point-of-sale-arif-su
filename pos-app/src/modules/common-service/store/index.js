import actions from './actions'
import getters from './getters'
import Custom from './custom'
import { mutations } from './mutations'

const state = {
  commonObj: {
    hasDropdownLoaded: false,
    divisionList: [],
    districtList: [],
    upazilaList: [],
    unionList: [],
    bankList: [],
    cityCorporationList: [],
    paurashavaList: [],
    shopList: [],
    roleList: [],
    categoryList: [],
    brandList: [],
    colorList: [],
    modelList: [],
    branchList: [],
    wardList: [],
    areaTypeList: Custom.areaTypeList
  }
}

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
}
