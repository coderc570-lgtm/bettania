<template>
    <div class="mx-auto min-h-screen rounded-lg shadow-md p-5 w-1/2">
        <ProfilePicture />
        <ProfileInfo />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import ProfileInfo from '@/components/Profile/ProfileInfo.vue';
import ProfilePicture from '@/components/Profile/ProfilePicture.vue';

export default defineComponent({
  name: 'ProfileSettings',
  components: { ProfileInfo, ProfilePicture },
  data() {
    return{
        //
    }
  },
});
</script>