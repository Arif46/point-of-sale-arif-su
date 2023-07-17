export const mutations = {
    setAccessToken (state, payload) {
        state.accessToken = payload
    },
    updateAuthUser (state, payload) {
        state.authUser = Object.assign({}, state.authUser, payload)
    },
    setAuthUserRoles (state, payload) {
        state.authUserRoles = payload
    },
    setActiveRole (state, payload) {
        state.activeRoleId = payload
    },
    setAuthorizedShops (state, payload) {
        state.authorizedShops = payload
    },
    setActiveShopId (state, payload) {
        state.activeShopId = payload
    },
    setActiveMenus (state, payload) {
        state.activeMenus = payload
    },
    setAuthorizedMenus (state, payload) {
        state.authorizedURIs = payload
    },
    setUnauthorizedAccessCounter (state, payload) {
        state.unauthorizedAccessCounter = payload
    },
    setCommonProfile (state, payload) {
        state.commonProfile = payload
    }
}
