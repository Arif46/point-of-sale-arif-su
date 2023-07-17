export default {
  mutateCommonObj ({ commit }, payload) {
    commit('mutateCommonObj', payload)
  },
  localizeDropdown ({ commit }, payload) {
    commit('localizeDropdown', payload)
  },
  // localizeDropdownExternal ({ commit }, payload) {
  //   commit('localizeDropdownExternal', payload)
  // },
  stateReload ({ commit }, payload) {
    commit('stateReload', payload)
  }
}
