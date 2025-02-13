<template>
  <div>
    <form-section>
      <template #title>Delete account</template>

      <div>
        <h2 class="font-semibold">Permanently delete your account</h2>

        <div class="mt-6 bg-gray-100 p-2 flex items-center">
          <svg
            class="w-16 h-16 ml-1 mr-4"
            viewBox="0 0 14 15"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.3335 8.33366H7.66683V12.3337H6.3335V8.33366ZM6.3335 5.66699H7.66683V7.00033H6.3335V5.66699Z"
              fill="#495057"
            />
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.14887 1.74936C7.08745 1.62652 6.91215 1.62652 6.85073 1.74936L1.26275 12.9253C1.20734 13.0361 1.28793 13.1665 1.41182 13.1665H12.5878C12.7117 13.1665 12.7923 13.0361 12.7368 12.9253L7.14887 1.74936ZM5.9563 1.30214C6.38625 0.442256 7.61335 0.442252 8.0433 1.30214L13.6313 12.4781C14.0191 13.2538 13.4551 14.1665 12.5878 14.1665H1.41182C0.544545 14.1665 -0.0195331 13.2538 0.368326 12.4781L5.9563 1.30214Z"
              fill="#495057"
            />
          </svg>

          <p class="text-darkgrey">
            Once your account is deleted, all of its resources and data will be
            permanently deleted. Before deleting your account, please download
            any data or information that you wish to retain.
          </p>
        </div>

        <div class="mt-6">
          <button
            class="secondary-btn"
            type="button"
            @click="confirmUserDeletion"
          >
            Delete
          </button>
        </div>
      </div>
    </form-section>

    <modal :is-open="confirmingUserDeletion" @close="closeModal">
      <template #title>Delete account permanently</template>

      <form @submit.prevent="deleteUser" class="py-6">
        <p class="text-darkgrey">
          Are you sure you want to delete your account? Once your account is
          deleted, all of its resources and data will be
          <span class="text-red-500 font-medium">permanently deleted</span>.
          Please enter your password to confirm you would like to permanently
          delete your account.
        </p>

        <div class="mt-4 form-group">
          <label class="form-label">Password</label>
          <text-input
            type="password"
            v-model="form.password"
            required
            minlength="8"
          />

          <input-error :message="form.errors.password" />
        </div>

        <div class="flex gap-3 mt-4">
          <button class="secondary-btn" @click="closeModal" type="button">
            Cancel
          </button>
          <primary-button :disabled="form.processing"
            >Delete account</primary-button
          >
        </div>
      </form>
    </modal>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import FormSection from '@/Components/Common/FormSection.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import Modal from '@/Components/Common/Modal.vue'
import InputError from '@/Components/Form/InputError.vue'

const form = useForm({
  password: ''
})

const confirmingUserDeletion = ref(false)

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true
}

const deleteUser = () => {
  form.delete(route('current-user.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onFinish: () => form.reset()
  })
}

const closeModal = () => {
  confirmingUserDeletion.value = false

  form.reset()
}
</script>
