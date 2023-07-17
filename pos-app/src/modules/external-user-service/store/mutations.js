export const mutations = {
    // CIP panel mutations start
    mutateCipPanelCommonObj (state, payload) {
        state.cipPanel.commonObj = Object.assign({}, state.cipPanel.commonObj, payload)
    },
    addCurrentCircular (state, payload) {
        state.cipPanel.commonObj.circular = payload
    },
    localizeCipPanelDropdown (state, payload) {
        // state.cipPanel.commonObj.circularList = state.cipPanel.commonObj.circularList.map(item => {
        //     const tmp = payload.value === 'en' ? { text: item.text_en } : { text: item.text_bn }
        //     return Object.assign({}, item, tmp)
        // })
        state.cipPanel.commonObj.exportSectorList = state.cipPanel.commonObj.exportSectorList.map(item => {
            const tmp = payload.value === 'en' ? { text: item.text_en } : { text: item.text_bn }
            return Object.assign({}, item, tmp)
        })
        state.cipPanel.commonObj.venueList = state.cipPanel.commonObj.venueList.map(item => {
            const tmp = payload.value === 'en' ? { text: item.text_en } : { text: item.text_bn }
            return Object.assign({}, item, tmp)
        })
      },
    // CIP panel mutations end
    setExternalMenus (state, payload) {
        state.externalMenus = payload
    },
    setExternalPanels (state, payload) {
        state.externalPanels = payload
    },
    isInsidePanel (state, payload) {
        state.isInsidePanel = payload
    }
}
