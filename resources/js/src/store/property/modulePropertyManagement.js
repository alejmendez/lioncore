import state from './modulePropertyManagementState.js'
import mutations from './modulePropertyManagementMutations.js'
import actions from './modulePropertyManagementActions.js'
import getters from './modulePropertyManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
