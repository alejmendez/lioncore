import state from './moduleRegistroManagementState.js'
import mutations from './moduleRegistroManagementMutations.js'
import actions from './moduleRegistroManagementActions.js'
import getters from './moduleRegistroManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

