import axios from '@/axios.js'
import qs from 'qs'

export default {
  fetch (context, params) {
    return new Promise((resolve, reject) => {
      axios.get('graficas/data', {
        params,
        paramsSerializer: params => {
          return qs.stringify(params)
        }
      })
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
