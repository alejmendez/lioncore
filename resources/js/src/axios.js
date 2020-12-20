// axios
import axios from 'axios'

const baseURL = 'http://127.0.0.1:8000/api/v1/'

const axiosReturn = axios.create({
  baseURL
  // You can add your headers here
})

const accessToken = localStorage.getItem('accessToken')

if (accessToken) {
  axiosReturn.defaults.headers.common['Authorization'] = `bearer ${accessToken}`
}

export default axiosReturn
