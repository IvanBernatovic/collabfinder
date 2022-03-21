<template>
  <div>
    <form-section>
      <template #title>Active sessions</template>
      <div>
        <p class="text-gray-600">
          Manage and logout your active sessions on other browsers and devices.
        </p>

        <div
          v-for="session in sessions"
          class="flex py-4 items-center border-b border-gray-300 text-sm font-medium"
        >
          <desktop-computer-icon
            class="w-10 h-10 mr-4 text-gray-500"
            v-if="session.agent.is_desktop"
          />
          <device-mobile-icon
            class="w-10 h-10 mr-4 text-gray-500"
            v-if="!session.agent.is_desktop"
          />
          <div class="flex flex-col justify-between h-11 flex-1">
            <div class="text-gray-800">
              {{ session.agent.platform }} - {{ session.agent.browser }}
            </div>
            <div class="text-gray-400">
              {{ session.ip_address }}
              <span v-if="session.is_current_device" class="text-primary"
                >This device</span
              >
            </div>
          </div>
        </div>

        <div class="mt-6">
          <button class="secondary-btn" @click="confirmLogout">
            Logout other sessions
          </button>
        </div>
      </div>
    </form-section>

    <modal :is-open="confirmingLogout" @close="closeModal">
      <template #title>Logout other browser sessions</template>

      <form @submit.prevent="logoutOtherBrowserSessions" class="py-6">
        <div class="form-group">
          <label class="form-label">Password</label>
          <text-input type="password" v-model="form.password" />
        </div>

        <div class="flex gap-3 mt-4">
          <button class="secondary-btn" @click="closeModal" type="button">
            Cancel
          </button>
          <primary-button :disabled="form.processing"
            >Logout other browser sessions</primary-button
          >
        </div>
      </form>
    </modal>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { DesktopComputerIcon, DeviceMobileIcon } from '@heroicons/vue/solid'
import { useToast } from 'vue-toastification'

import FormSection from '@/Components/Common/FormSection.vue'
import Modal from '@/Components/Common/Modal.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'

const props = defineProps(['sessions'])

const form = useForm({
  password: ''
})

const toast = useToast()

const confirmingLogout = ref(false)

const confirmLogout = () => {
  confirmingLogout.value = true
}

const closeModal = () => {
  confirmingLogout.value = false

  form.reset()
}

const logoutOtherBrowserSessions = () => {
  form.delete('/user/other-browser-sessions', {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      toast.success('Logged out of other browsers successfully.')
    },
    onFinish: () => form.reset()
  })
}
</script>
