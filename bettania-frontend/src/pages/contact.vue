<template>
  <div class="flex flex-col items-center px-6 md:px-24 py-12">
    <h2
      class="text-4xl font-medium text-gray-800 mb-6"
      data-aos="fade-up"
    >
      Contact
    </h2>

    <form
      class="max-w-2xl w-full space-y-6"
      data-aos="fade-up"
      data-aos-duration="600"
    >
      <BaseInput
        id="name"
        name="name"
        label="Name"
        v-model="form.name"
        required
      />

      <BaseInput
        id="email"
        name="email"
        label="Email"
        v-model="form.email"
        required
      />

      <BaseInput
        id="phone"
        name="phone"
        label="Phone"
        v-model="form.phone"
        required
      />

      <Textarea
        label="Comment"
        id="comment"
        v-model="form.comment"
        rows="4"
      />

      <div>
        <button
          type="submit"
          class="bg-deep-plum text-white px-12 py-3 rounded hover:bg-gray-800 transition"
        >
          Send
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import BaseInput from '@/components/Base/BaseInput.vue'
import Textarea from '@/components/Base/BaseTextArea.vue'

export default {
  name: 'Contact',
  components: {
    BaseInput,
    Textarea,
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        comment: '',
      },
    };
  },
};
</script>
