// axios
import axios from 'axios'

const baseURL = 'http://lioncore.oo/v1/api/'

export default axios.create({
  baseURL
  // You can add your headers here
})
