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
  }
}
