<template>
    <div class="max-w-lg mx-auto my-10 bg-white">
        <form class="max-w-md w-full mx-auto">
            <div class="relative z-0 w-full mb-5 group">
                <BaseInput
                    type="email"
                    name="email"
                    label="Your email"
                    placeholder="name@company.com"
                    customClass="w-full"
                />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <BaseInput
                    type="password"
                    name="password"
                    label="Password"
                    placeholder="••••••••"
                    customClass="w-full"
                />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <BaseInput
                    type="password"
                    name="repeat_password"
                    label="Confirm password"
                    placeholder="••••••••"
                    customClass="w-full"
                />
            </div>
            <div class="grid md:grid-cols-2 md:gap-3">
                <div class="relative z-0 w-full mb-5 group">
                    <BaseInput
                        type="text"
                        name="first-name"
                        label="First name"
                        placeholder="Ex: Jerven"
                        customClass="w-full"
                    />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <BaseInput
                        type="text"
                        name="last-name"
                        label="Last name"
                        placeholder="Ex: Latayada*"
                        customClass="w-full"
                    />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <BaseInput
                        type="tel"
                        name="city"
                        label="City"
                        placeholder="Ex: Davao City"
                        customClass="w-full"
                        required
                    />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <BaseInput
                        type="text"
                        name="state"
                        label="State/Province"
                        placeholder="Ex: Davao Del Sur"
                        customClass="w-full"
                        required
                    />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <BaseInput
                        type="text"
                        name="country"
                        label="Country"
                        placeholder="Ex: Philippines"
                        customClass="w-full"
                        required
                    />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <BaseInput
                        type="text"
                        name="postal-code"
                        label="Postal Code"
                        placeholder="Ex: 8000"
                        customClass="w-full"
                        required
                    />
                </div>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <BaseInput
                    type="email"
                    name="website-link"
                    label="Website Link"
                    placeholder="Ex: http://www.google.com"
                    customClass="w-full"
                    required
                />
            </div>
            <div class="flex justify-center">
                <BaseButton
                label="Update Profile"
                type="submit"
                customClass="w-40"
                />
            </div>
        </form>
    </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import BaseButton from '@/components/Base/BaseButton.vue';
import BaseInput from '@/components/Base/BaseInput.vue';

export default defineComponent({
  name: 'CreateEvent',
  components: {
    BaseButton,
    BaseInput,
   },
  data() {
    return{
        //
    }
  },
});
</script>