// axios
import axios from 'axios'

const baseURL = 'http://lioncore.oo/api/v1/'

export default axios.create({
  baseURL
  // You can add your headers here
})
