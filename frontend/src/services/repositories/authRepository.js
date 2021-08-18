import axios from '../../plugins/axios';
const resource = '/api';

export default {
  login(payload) {
    return axios.post(`${resource}/login`, payload);
  },
  register(payload) {
    return axios.post(`${resource}/register`, payload);
  },
  logout() {
    return axios.post(`${resource}/logout`);
  },
}