export default {
    setAccessToken ({ commit }, payload) {
        commit('setAccessToken', payload)
    },
    updateAuthUser ({ commit }, payload) {
        commit('updateAuthUser', payload)
    },
    setAuthUserRoles ({ commit }, payload) {
        commit('setAuthUserRoles', payload)
    },
    setActiveRole ({ commit }, payload) {
        commit('setActiveRole', payload)
    },
    setAuthorizedShops ({ commit }, payload) {
        commit('setAuthorizedShops', payload)
    },
    setActiveShopId ({ commit }, payload) {
        commit('setActiveShopId', payload)
    },
    setActiveMenus ({ commit }, payload) {
        commit('setActiveMenus', payload)
    },
    setAuthorizedMenus ({ commit }, payload) {
        commit('setAuthorizedMenus', payload)
    },
    setUnauthorizedAccessCounter ({ commit }, payload) {
        commit('setUnauthorizedAccessCounter', payload)
    },
    setCommonProfile ({ commit }, payload) {
        commit('setCommonProfile', payload)
    }
}
