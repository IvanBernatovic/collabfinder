<template>
  <div class="justify-center">
    <div class="py-10 flex w-2/3 mx-auto">
      <div class="bg-gray-300 relative flex-grow line"></div>
      <div class="px-5 text-gray-600">{{ text }}</div>
      <div class="bg-gray-300 relative flex-grow line"></div>
    </div>

    <div class="flex gap-x-2 justify-center text-gray-700">
      <a
        class="secondary-btn h-[36px] capitalize"
        v-for="provider in socialProviders"
        :key="provider"
        :href="`auth/login/${provider}`"
      >
        <i :class="`fab fa-${provider} mr-2`"></i>
        {{ provider }}
      </a>
    </div>
  </div>
</template>

<script>
import SecondaryButton from 'Components/Common/SecondaryButton.vue'

export default {
  props: {
    text: {
      type: String,
      default: 'Or sign in with'
    }
  },
  components: {
    SecondaryButton
  },
  data() {
    return {
      socialProviders: ['github', 'google', 'twitter']
    }
  }
}
</script>
