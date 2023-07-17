import actions from './actions'
import getters from './getters'
import { mutations } from './mutations'

const state = {
  isLoggedIn: false,
  accessToken: null,
  authUser: null,
  authUserRoles: [],
  activeRoleId: 0,
  authorizedShops: [],
  activeShopId: 0,
  activeMenus: [],
  authorizedURIs: ['/home'],
  unauthorizedAccessCounter: 0,
  commonProfile: {}
}

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
}
