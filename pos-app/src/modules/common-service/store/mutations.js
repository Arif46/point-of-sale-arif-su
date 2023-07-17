export const mutations = {
  mutateCommonObj (state, payload) {
    state.commonObj = Object.assign({}, state.commonObj, payload)
  },
  localizeDropdown (state, payload) {
    state.commonObj = Object.assign({}, state.commonObj, payload)
    // state.commonObj.divisionList = state.commonObj.divisionList.map(item => {
    //   const tmp = { text: item.text }
    //   return Object.assign({}, item, tmp)
    // })
  }
  // localizeDropdownExternal (state, payload) {
  //   state.commonObj.divisionList = state.commonObj.divisionList.map(item => {
  //     const tmp = payload.value === 'en' ? { text: item.text_en } : { text: item.text_bn }
  //     return Object.assign({}, item, tmp)
  //   })
  //   state.commonObj.districtList = state.commonObj.districtList.map(item => {
  //     const tmp = payload.value === 'en' ? { text: item.text_en } : { text: item.text_bn }
  //     return Object.assign({}, item, tmp)
  //   })
  // }
}
