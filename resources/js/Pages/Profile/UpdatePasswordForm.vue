<template>
  <div>
    <form-section>
      <template #title>Update password</template>

      <form @submit.prevent="submit" class="flex flex-col gap-6">
        <div class="form-group">
          <label for="current_password" class="form-label"
            >Current password</label
          >
          <text-input
            name="current_password"
            id="current_password"
            type="password"
            v-model="form.current_password"
            minlength="8"
          />

          <input-error
            :message="form.errors?.updatePassword?.current_password"
          />
        </div>

        <div class="form-group">
          <label for="password" class="form-label">New password</label>
          <text-input
            name="password"
            id="password"
            type="password"
            v-model="form.password"
            minlength="8"
          />

          <input-error :message="form.errors?.updatePassword?.password" />
        </div>

        <div class="form-group">
          <label for="password_confirmation" class="form-label"
            >Confirm password</label
          >
          <text-input
            name="password_confirmation"
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            minlength="8"
          />
          <input-error
            :message="form.errors?.updatePassword?.password_confirmation"
          />
        </div>

        <div>
          <primary-button type="submit" :disabled="form.processing"
            >Save</primary-button
          >
        </div>
      </form>
    </form-section>
  </div>
</template>

<script setup>
import FormSection from '@/Components/Common/FormSection.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import { useToast } from 'vue-toastification'

import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import InputError from '@/Components/Form/InputError.vue'

const toast = useToast()
const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

const submit = () =>
  form.put('/user/password', {
    preserveScroll: true,
    onSuccess() {
      toast.success('Password updated.')
      form.reset()
    }
  })
</script>
