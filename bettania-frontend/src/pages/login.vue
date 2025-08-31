<template>
  <section class="min-h-auto md:min-h-[90vh] bg-light-gray flex flex-col md:flex-row">

    <div class="hidden md:flex w-full md:w-1/2 items-center justify-center px-6 py-12 bg-gray-100">
      <div class="flex flex-col items-center text-9xl font-semibold space-y-2">
        <span
          class="text-deep-plum"
          data-aos="zoom-in"
          data-aos-easing="ease-out-back"
          data-aos-delay="0"
        >
          Crafted
        </span>
        <span
          class="ml-64 text-soft-gray"
          data-aos="zoom-in"
          data-aos-easing="ease-out-back"
          data-aos-delay="150"
        >
          Suits  
        </span>
        <span
          class="text-deep-plum"
          data-aos="zoom-in"
          data-aos-easing="ease-out-back"
          data-aos-delay="300"
        >
          Perfectly
        </span>
        <span
          class="ml-28 pt-4 text-deep-plum text-4xl"
          data-aos="zoom-in"
          data-aos-easing="ease-out-back"
          data-aos-delay="450"
        >
          Create Your Signature Style
        </span>
      </div>
    </div>

    <div class="w-full md:w-1/2 flex flex-col items-center justify-center px-6 py-12">
      <router-link
        :to="{ name: 'home' }"
          class="hidden md:block mb-6 text-2xl font-semibold text-gray-900 dark:text-dark-gray"
      >
        <img :src="logo" width="200" alt="Bettania Logo" />
      </router-link>

      <div class="w-full bg-white rounded-lg shadow-md sm:max-w-md">
        <div class="p-6 space-y-6">
          <h2 class="text-2xl font-bold text-gray-900 dark:text-dark-gray">
            Sign in to your account
          </h2>

          <form @submit.prevent="loginUser" class="space-y-4">
            <BaseInput
              v-model="email"
              id="email"
              name="email"
              label="Email"
              placeholder="name@example.com"
              required
            />

            <BaseInput
              v-model="password"
              id="password"
              name="password"
              label="Password"
              placeholder="••••••••"
              type="password"
              required
            />

            <div class="flex items-center justify-between text-sm">
              <label class="flex items-center gap-2">
                <input
                  type="checkbox"
                  class="rounded border-gray-300 text-deep-plum focus:ring-primary-500"
                />
                <span class="text-gray-600">Remember me</span>
              </label>
              <a href="#" class="text-deep-plum hover:underline">Forgot password?</a>
            </div>

            <button
              type="submit"
              class="w-full rounded text-white px-6 py-3 text-sm
              tracking-wide bg-deep-plum hover:bg-l-deep-plum transition"
            >
              Sign In
            </button>

            <p class="text-sm text-gray-500 text-center">
              Don’t have an account yet?
              <router-link
                :to="{ name: 'register' }"
                class="font-medium text-deep-plum hover:underline"
              >
                Sign up
              </router-link>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { defineComponent } from 'vue';
import { useAuthStore } from '@/store/authLogin';
// import BaseButton from '@/components/Base/BaseButton.vue';
import BaseInput from '@/components/Base/BaseInput.vue';
import logo from '@/assets/images/bettania-logo.png';

export default defineComponent({
  name: 'UserLogin',
  components: {
    // BaseButton,
    BaseInput,
  },
  data() {
    return {
      email: '',
      password: '',
      logo,
    };
  },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
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
});
</script>
