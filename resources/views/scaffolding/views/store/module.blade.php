import state from './module{{ ucfirst($nameModel) }}ManagementState.js'
import mutations from './module{{ ucfirst($nameModel) }}ManagementMutations.js'
import actions from './module{{ ucfirst($nameModel) }}ManagementActions.js'
import getters from './module{{ ucfirst($nameModel) }}ManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

