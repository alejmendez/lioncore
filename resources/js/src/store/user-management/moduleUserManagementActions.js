/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from '@/axios.js'
import qs from 'qs'

export default {
  // addItem({ commit }, item) {
  //   return new Promise((resolve, reject) => {
  //     axios.post("/api/data-list/products/", {item: item})
  //       .then((response) => {
  //         commit('ADD_ITEM', Object.assign(item, {id: response.data.id}))
  //         resolve(response)
  //       })
  //       .catch((error) => { reject(error) })
  //   })
  // },
  getFiltersValues ({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.get('users/filters', data)
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
  list ({ commit }, params) {
    return new Promise((resolve) => {
      axios.get('users', {
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
  fetchUser (context, id) {
    return new Promise((resolve, reject) => {
      axios.get(`users/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord ({ commit }, id) {
    return new Promise((resolve, reject) => {
      axios.delete(`users/${id}`)
        .then((response) => {
          commit('REMOVE_RECORD', id)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
