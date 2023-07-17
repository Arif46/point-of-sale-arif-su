export default {
    // CIP panel action start
    mutateCipPanelCommonObj ({ commit }, payload) {
        commit('mutateCipPanelCommonObj', payload)
    },
    localizeCipPanelDropdown ({ commit }, payload) {
        commit('localizeCipPanelDropdown', payload)
    },
    localizeBftiPanelDropdown ({ commit }, payload) {
        commit('localizeBftiPanelDropdown', payload)
    },
    addCurrentCircular ({ commit }, payload) {
        commit('addCurrentCircular', payload)
    },
    // CIP panel action end
    setExternalMenus ({ commit }, payload) {
        commit('setExternalMenus', payload)
    },
    setExternalPanels ({ commit }, payload) {
        commit('setExternalPanels', payload)
    },
    isInsidePanel ({ commit }, payload) {
        commit('isInsidePanel', payload)
    }
}
