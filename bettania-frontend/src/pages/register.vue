<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="border p-9 shadow-lg">
        <form @submit.prevent="registerUser" class="max-w-md mx-auto flex flex-col space-y-5">
          <p class="text-dark-gray text-2xl text-center font-bold">Register Here</p>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="email"
              v-model="email"
              name="floating_email"
              id="floating_email"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900
              dark:border-gray-600 dark:focus:border-primary-600 focus:outline-none focus:ring-0 focus:border-primary-600 peer"
              placeholder=" "
              required />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
              peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-primary-600 peer-focus:dark:text-primary-600 peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
              Email address
            </label>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="password"
              v-model="password"
              name="floating_password"
              id="floating_password"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none
              dark:text-gray-900 dark:border-gray-600 dark:focus:border-primary-600 focus:outline-none focus:ring-0 focus:border-primary-600 peer"
              placeholder=" "
              required />
            <label
              for="floating_password"
              class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
              peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-primary-600 peer-focus:dark:text-primary-600
              peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
              Password
            </label>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="password"
              v-model="repeatPassword"
              name="repeat_password"
              id="floating_repeat_password"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none
              dark:text-gray-900 dark:border-gray-600 dark:focus:border-primary-600 focus:outline-none focus:ring-0 focus:border-primary-600 peer"
              placeholder=" " required />
            <label for="floating_repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6
              scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-primary-600 peer-focus:dark:text-primary-600
              peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
              Confirm password
            </label>
          </div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="text"
                v-model="firstName"
                name="floating_first_name"
                id="floating_first_name"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900
                dark:border-gray-600 dark:focus:border-primary-600 focus:outline-none focus:ring-0 focus:border-primary-600 peer"
                placeholder=" "
                required />
              <label 
                  for="floating_first_name" 
                  class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                  peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-primary-600 peer-focus:dark:text-primary-600
                  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                  First name
              </label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input
                  type="text"
                  v-model="lastName"
                  name="floating_last_name"
                  id="floating_last_name"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none
                  dark:text-gray-900 dark:border-gray-600 dark:focus:border-primary-600 focus:outline-none focus:ring-0 focus:border-primary-600 peer" placeholder=" " required />
              <label
                  for="floating_last_name"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                  peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-primary-600 peer-focus:dark:text-primary-600
                  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                  Last name
              </label>
            </div>
          </div>
          <!-- <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-5 group">
              <input
              type="tel"
              pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
              name="floating_phone" id="floating_phone"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600
              dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
              <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                  peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500
                  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                  Ex. (123-456-7890)
              </label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input
                  type="text"
                  name="floating_company"
                  id="floating_company"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white
                  dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
              <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3
                  -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-blue-600
                  peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                  Company (Ex. Google)
              </label>
            </div>
          </div> -->
          <button
              type="submit"
              class="w-full rounded text-white px-6 py-3 text-sm
              tracking-wide bg-deep-plum hover:bg-l-deep-plum transition"
            >
              Submit
            </button>
        </form>
      </div>
    </div>
</template>
  
      
<script lang="ts">
import { defineComponent} from 'vue';
import { axiosInstance } from '@/axios/axios';

export default defineComponent({
    name: 'SignUp',
    data() {
      return {
        email: '',
        password: '',
        repeatPassword: '',
        firstName: '',
        lastName: '',
      }
    },
    methods: {
    async registerUser() {
      try {
        const response = await axiosInstance.post('v1/sign-up/', {
          first_name: this.firstName,
          last_name: this.lastName,
          email: this.email,
          password: this.password
        });

        this.$notify({
          type: 'success',
          title: 'Success',
          text: response.data.message
        });
        
        this.firstName = '';
        this.lastName = '';
        this.email = '';
        this.password = '';
        this.repeatPassword = '';
        
      } catch (error: any) {
        if (error.response && error.response.data.errors) {
          this.$notify({
            type: 'error',
            title: 'Error',
            text: error.response.data.errors.join(', ')
          });
        } else {
          this.$notify({
            type: 'error',
            title: 'Error',
            text: 'An error occurred. Please try again.'
          });
        }
      }
    }
  }
});
</script>