import { App } from 'vue';
import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: process.env.VUE_APP_BASE_URL + process.env.VUE_APP_API_PATH,
    withCredentials: true,
});

axiosInstance.interceptors.response.use(
  response => response,
  error => {
      console.error('Axios Error:', error);
      return Promise.reject(error);
  }
);

export default {
    install(app: App) {
        app.config.globalProperties.$axios = axiosInstance;
        app.provide('axios', axiosInstance);
    },
};

export { axiosInstance };
