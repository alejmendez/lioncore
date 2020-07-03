import axios from '../../../axios/index.js'
import store from '../../../../store/store.js'

// Token Refresh
let isAlreadyFetchingAccessToken = false
let subscribers = []

function onAccessTokenFetched (access_token) {
  subscribers = subscribers.filter(callback => callback(access_token))
}

function addSubscriber (callback) {
  subscribers.push(callback)
}

export default {
  init () {
    axios.interceptors.response.use(function (response) {
      return response
    }, function (error) {
      // const { config, response: { status } } = error
      const { config, response } = error
      const originalRequest = config

      if (response.status >= 400) {
        //console.log(Vue.prototype.$vs)
        //Vue.prototype.$vs.loading.close()
      }

      if (response && response.status === 403) {
        store.dispatch('auth/forbidden')
          .then(() => {})
      }

      if (response && response.status === 401) {
        if (!isAlreadyFetchingAccessToken) {
          isAlreadyFetchingAccessToken = true
          store.dispatch('auth/fetchAccessToken')
            .then((access_token) => {
              isAlreadyFetchingAccessToken = false
              onAccessTokenFetched(access_token)
            })
        }

        const retryOriginalRequest = new Promise((resolve) => {
          addSubscriber(access_token => {
            originalRequest.headers.Authorization = `bearer ${access_token}`
            resolve(axios(originalRequest))
          })
        })
        return retryOriginalRequest
      }
      return Promise.reject(error)
    })
  },
  login (email, pwd) {
    return axios.post('/auth/login', {
      email,
      password: pwd
    })
  },
  registerUser (name, email, pwd) {
    return axios.post('/auth/register', {
      displayName: name,
      email,
      password: pwd
    })
  },
  refreshToken () {
    return axios.post('/auth/refresh', {accessToken: localStorage.getItem('accessToKen')})
  }
}
