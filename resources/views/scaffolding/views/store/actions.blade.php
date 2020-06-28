import axios from '@/axios.js'
import qs from 'qs'

export default {
  getFiltersValues ({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.get('{{ $nameModelPlural }}/filters', data)
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
      axios.get('{{ $nameModelPlural }}/module-data')
        .then((response) => {
          commit('SET_MODULE_DATA', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  list ({ commit }, params) {
    return new Promise((resolve) => {
      axios.get('{{ $nameModelPlural }}', {
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
      axios.get(`{{ $nameModelPlural }}/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  save (context, data) {
    return new Promise((resolve, reject) => {
      let promise;
      if (data.id == '') {
        promise = axios.post(`{{ $nameModelPlural }}`, data)
      } else {
        promise = axios.put(`{{ $nameModelPlural }}/${data.id}`, data)
      }
      promise
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord ({ commit }, id) {
    return new Promise((resolve, reject) => {
      axios.delete(`{{ $nameModelPlural }}/${id}`)
        .then((response) => {
          commit('REMOVE_RECORD', id)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
