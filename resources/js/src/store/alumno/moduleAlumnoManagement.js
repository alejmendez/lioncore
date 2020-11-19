import state from './moduleAlumnoManagementState.js'
import mutations from './moduleAlumnoManagementMutations.js'
import actions from './moduleAlumnoManagementActions.js'
import getters from './moduleAlumnoManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

