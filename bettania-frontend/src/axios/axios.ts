// import { App } from 'vue'
// import axios from 'axios'

// const axiosInstance = axios.create({
//     withCredentials: true,
//     headers: {
//       "X-Requested-With": "XMLHttpRequest",
//   },
//     // Add other custom configurations if needed
// })

// // Add a request interceptor to add CSRF token and set baseURL
// axiosInstance.interceptors.request.use(config => {
//     const token = document.head.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
//     config.baseURL = process.env.VUE_APP_BASE_URL + process.env.VUE_APP_API_PATH;
//     if (token) {
//         config.headers['X-CSRF-TOKEN'] = token;
//     }
//     console.log('CSRF Token:', token);
//     return config;
// });

// export default {
//     install(app: App) {
//         app.config.globalProperties.$axios = axiosInstance
//         app.provide('axios', axiosInstance)
//     }
// }

// // Optionally export the axios instance for use in non-component files
// export { axiosInstance }


import { App } from 'vue';
import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: process.env.VUE_APP_BASE_URL + process.env.VUE_APP_API_PATH,
    withCredentials: true,
    // Add other custom configurations if needed
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
