import axios from '@/axios.js'
import qs from 'qs'

export default {
  getFiltersValues ({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.get('registros/filters', data)
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
      axios.get('registros/module-data')
        .then((response) => {
          commit('SET_MODULE_DATA', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  list ({ commit }, params) {
    return new Promise((resolve) => {
      axios.get('registros', {
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
      axios.get(`registros/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  save (context, data) {
    return new Promise((resolve, reject) => {
      let promise = null
      if (data.id === '' || data.id === 0 || data.id === '0') {
        promise = axios.post('registros', data)
      } else {
        promise = axios.put(`registros/${data.id}`, data)
      }
      promise
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  delete ({ commit }, id) {
    return new Promise((resolve, reject) => {
      axios.delete(`registros/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
