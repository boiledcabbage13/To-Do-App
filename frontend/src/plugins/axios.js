import axios from "axios";

const API_URL = process.env.VUE_APP_API_URL;
// const API_URL = 'http://192.168.254.107:80';

// const API_VERSION = process.env.VUE_APP_API_VER;
// const REQUEST_TYPE = process.env.VUE_APP_REQUEST_TYPE;
// const BASE_URL = API_URL + REQUEST_TYPE + "/" + API_VERSION + "/";
const BASE_URL = API_URL;

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.post["Content-Type"] = "application/json; charset=utf-8";
axios.defaults.baseURL = BASE_URL;

let config = {};

const instance = axios.create(config);
// const instance = axios.create({});

// Add a request interceptor
instance.interceptors.request.use(
  async config => {
    // Do something before request is sent
    //add Authentication
    const accessToken = await localStorage.getItem('token');
    
    if (accessToken) {
      config.headers.Authorization = `Bearer ${accessToken}`;
    } else {
      config.headers.Authorization = "";
    }


    return config;
  },
  error => {
    // Do something with request error
    return Promise.reject(error);
  }
);

// Add a response interceptor
instance.interceptors.response.use(
  response => {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    return response;
  },
  error => {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    return Promise.reject(error);
  }
);

export default instance;
