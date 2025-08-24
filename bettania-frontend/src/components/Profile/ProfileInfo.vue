<template>
  <div class="max-w-3xl mx-auto my-12 px-4 sm:px-6 lg:px-8">
    <form class="bg-white p-8 space-y-6" @submit.prevent="submitForm">
      <div class="space-y-4">
        <BaseInput
          v-model="form.email"
          id="email"
          name="email"
          type="email"
          label="Your Email"
          placeholder="name@company.com"
          required
        />

        <BaseInput
          v-model="form.password"
          id="password"
          name="password"
          type="password"
          label="Password"
          placeholder="••••••••"
          required
        />

        <BaseInput
          v-model="form.repeat_password"
          id="repeat_password"
          name="repeat_password"
          type="password"
          label="Confirm Password"
          placeholder="••••••••"
          required
        />
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <BaseInput
          v-model="form.first_name"
          id="first_name"
          name="first_name"
          label="First Name"
          placeholder="Ex: Jerven"
          required
        />

        <BaseInput
          v-model="form.last_name"
          id="last_name"
          name="last_name"
          label="Last Name"
          placeholder="Ex: Latayada"
          required
        />

        <BaseInput
          v-model="form.city"
          id="city"
          name="city"
          type="text"
          label="City"
          placeholder="Ex: Davao City"
          required
        />

        <BaseInput
          v-model="form.state"
          id="state"
          name="state"
          type="text"
          label="State/Province"
          placeholder="Ex: Davao Del Sur"
          required
        />

        <BaseInput
          v-model="form.country"
          id="country"
          name="country"
          type="text"
          label="Country"
          placeholder="Ex: Philippines"
          required
        />

        <BaseInput
          v-model="form.postal_code"
          id="postal_code"
          name="postal_code"
          type="text"
          label="Postal Code"
          placeholder="Ex: 8000"
          required
        />
      </div>

      <BaseInput
        v-model="form.website"
        id="website"
        name="website"
        type="url"
        label="Website Link"
        placeholder="https://www.example.com"
        required
      />

      <div class="flex justify-center pt-4">
        <BaseButton
          label="Update Profile"
          type="submit"
          customClass="w-40"
        />
      </div>
    </form>
  </div>
</template>

<script>
import BaseButton from '@/components/Base/BaseButton.vue';
import BaseInput from '@/components/Base/BaseInput.vue';

export default {
  name: 'ProfileInfo',
  components: {
    BaseButton,
    BaseInput,
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
        repeat_password: '',
        first_name: '',
        last_name: '',
        city: '',
        state: '',
        country: '',
        postal_code: '',
        website: '',
      },
    };
  },
};
</script>
