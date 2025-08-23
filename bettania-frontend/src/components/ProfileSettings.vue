<template>
    <div class="min-h-auto bg-white flex flex-col px-16 md:px-24 py-12">
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