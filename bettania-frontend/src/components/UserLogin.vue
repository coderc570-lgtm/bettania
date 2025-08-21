<template>
  <section class="bg-light-gray min-h-screen flex">
    <!-- Left column -->
    <div class="font-sans md:block md:w-1/2 my-auto px-6">
      <div class="flex flex-col items-center text-9xl font-semibold space-y-2">
        <span class="text-dark-gray">Events</span>
        <span class="ml-44 text-rose ">Made</span>
        <span class="text-dark-gray">Simple</span>
        <span class="ml-28 pt-4 text-dark-gray text-4xl">Create unforgettable moments</span>
      </div>
    </div>
    <!-- Right column -->
    <div class="flex flex-col items-center justify-center w-full md:w-1/2 px-6 py-8 mx-auto lg:py-0">
      <router-link
        :to="{ name: 'home' }"
        class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-dark-gray">
        <img
          src="https://imgur.com/Z4D4Cx5.png"
          width="200"
          alt="logo">
      </router-link>
      <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-dark-gray">
            Sign in to your account
          </h1>
          <form @submit.prevent="loginUser" class="space-y-4 md:space-y-6" action="#">
            <div>
              <BaseInput
                type="email"
                v-model="email"
                name="email"
                label="Your email"
                placeholder="name@company.com"
                customClass="w-full"
              />
            </div>
            <div>
              <BaseInput
                type="password"
                v-model="password"
                name="password"
                label="Password"
                placeholder="••••••••"
                customClass="w-full"
              />
            </div>
            <div class="flex items-center justify-between">
              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input
                  id="remember"
                  aria-describedby="remember"
                  type="checkbox"
                  class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300
                  dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                  required>
                </div>
                <div class="ml-3 text-sm">
                  <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                </div>
              </div>
              <a
                href="#"
                class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
                Forgot password?
              </a>
            </div>
            <BaseButton
              label="Sign in"
              type="submit"
              customClass="w-full"
            />
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              Don’t have an account yet? 
              <router-link :to="{ name: 'register' }" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</router-link>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from '@/store/authLogin';
import BaseButton from '../components/Base/BaseButton.vue';
import BaseInput from '../components/Base/BaseInput.vue';

export default defineComponent({
  name: 'UserLogin',
  components: { 
    BaseButton,
    BaseInput 
  },
  data() {
    return {
      email: '',
      password: ''
    };
  },

  setup() {
    const authStore = useAuthStore();

    return {
      authStore,
    };
  },

  methods: {
     loginUser() {
      this.authStore.login({
      email: this.email,
      password: this.password,
    });
      this.email = '';
      this.password = '';
    },
  },
  
  // methods: {
  //   async loginUser() {
  //     try {
  //       await this.$axios.get(process.env.VUE_APP_BASE_URL + '/sanctum/csrf-cookie');

  //         const response = await this.$axios.post('/v1/auth/login', {
  //         email: this.email,
  //         password: this.password
  //       });

  //       this.$notify({
  //         type: 'success',
  //         title: 'Success',
  //         text: response.data.message
  //       });

  //       this.email = '';
  //       this.password = '';

  //       this.$router.push({ name: 'home' });
  //     } catch (error: any) {
  //       if (error.response && error.response.data.errors) {
  //         this.$notify({
  //           type: 'error',
  //           title: 'Error',
  //           text: error.response.data.errors.join(', ')
  //         });
  //       } else {
  //         this.$notify({
  //           type: 'error',
  //           title: 'Error',
  //           text: 'An error occurred. Please try again.'
  //         });
  //       }
  //     }
  //   }
  // }
});
</script>