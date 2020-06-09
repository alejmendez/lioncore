/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_MODULE_DATA (state, moduleData) {
    state.moduleData = moduleData
  },
  SET_FILTERS_VALUES (state, filtersValues) {
    state.filtersValues = filtersValues
  },
  SET_FILTERS (state, filters) {
    state.filters = filters
  },
  SET_DATA (state, data) {
    state.data = data
  },
  RECORDS_FILTERED (state, recordsFiltered) {
    state.recordsFiltered = recordsFiltered
  },
  RECORDS_TOTAL (state, recordsTotal) {
    state.recordsTotal = recordsTotal
  },
  GET (state, id) {
    console.log('GET', id)
  },
  SAVE (state, id) {
    console.log('SAVE', id)
  },
  DELETE (state, id) {
    console.log('delete', id)
  }
}
