import { defineStore } from 'pinia';
import { axiosInstance } from '@/axios/axios';
import router from '@/router'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    isLoggedIn: false,
  }),
  getters: {
    isAuthenticated: (state) => state.isLoggedIn,
    getUser: (state) => state.user,
  },
  actions: {
    async checkAuth() {
        try {
          const response = await axiosInstance.get('/v1/auth/check');
          this.user = response.data.user;
          this.isLoggedIn = response.data.isLoggedIn;
        } catch (error) {
          this.user = null;
          this.isLoggedIn = false;
        }
    },
    async login(credentials: { email: string; password: string }) {
      try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        
        const response = await axiosInstance.post('/v1/auth/login', credentials);
        this.user = response.data.user;
        this.isLoggedIn = true;
        this.$notify({
          type: 'success',
          title: 'Success',
          text: response.data.message
        });
        router.push({ name: 'home' });
      } catch (error: any) {
        let errorMessage = 'An unknown error occurred';

        if (error.response && error.response.data && error.response.data.error) {
            errorMessage = error.response.data.error;
        }
    
        this.$notify({
            type: 'error',
            title: 'Login Failed',
            text: errorMessage
        });
      }
    },
    logout() {
        this.user = null;
        this.isLoggedIn = false;
        axiosInstance.post('/v1/auth/logout').then(response => {
          this.$notify({
            type: 'success',
            title: 'Success',
            text: response.data.message
          });
          router.push({ name: 'login' });
        }).catch(error => {
          console.error('Logout failed:', error);
          this.$notify({
            type: 'error',
            title: 'Logout Failed',
            text: 'An error occurred while logging out.'
          });
        });
      }      
  },
});
