import state from './moduleGraficaManagementState.js'
import mutations from './moduleGraficaManagementMutations.js'
import actions from './moduleGraficaManagementActions.js'
import getters from './moduleGraficaManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

