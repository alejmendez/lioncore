import axios from '@/axios.js'
import qs from 'qs'

export default {
  getFiltersValues ({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.get('properties/filters', data)
        .then((response) => {
          commit('SET_FILTERS_VALUES', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  setFilters ({ commit }, data) {
    commit('SET_FILTERS', data)
  },
  getModuleData ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('properties/module-data')
        .then((response) => {
          commit('SET_MODULE_DATA', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  list ({ commit }, params) {
    return new Promise((resolve) => {
      axios.get('properties', {
        params,
        paramsSerializer: params => {
          return qs.stringify(params)
        }
      })
        .then((response) => {
          commit('SET_DATA', response.data.data)
          commit('RECORDS_FILTERED', response.data.recordsFiltered)
          commit('RECORDS_TOTAL', response.data.recordsTotal)
          resolve(response)
        })
    })
  },
  fetch (context, id) {
    return new Promise((resolve, reject) => {
      axios.get(`properties/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord ({ commit }, id) {
    return new Promise((resolve, reject) => {
      axios.delete(`properties/${id}`)
        .then((response) => {
          commit('REMOVE_RECORD', id)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
