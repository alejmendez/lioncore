import axios from '@/axios.js'
import qs from 'qs'

export default {
  getFiltersValues ({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.get('graficas/filters', data)
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
      axios.get('graficas/module-data')
        .then((response) => {
          commit('SET_MODULE_DATA', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  list ({ commit }, params) {
    return new Promise((resolve) => {
      axios.get('graficas', {
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
      axios.get(`graficas/${id}`)
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
        promise = axios.post('graficas', data)
      } else {
        promise = axios.put(`graficas/${data.id}`, data)
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
      axios.delete(`graficas/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
