<template>
  <form-section>
    <template #title>Profile Information</template>

    <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <text-input name="name" id="name" v-model="form.name" minlength="2" />

        <input-error :message="form.errors?.updateProfileInformation?.name" />
      </div>

      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <text-input
          name="email"
          type="email"
          id="email"
          v-model="form.email"
          required
        />

        <input-error :message="form.errors?.updateProfileInformation?.email" />
      </div>

      <div>
        <primary-button type="submit" :disabled="form.processing"
          >Save</primary-button
        >
      </div>
    </form>
  </form-section>
</template>

<script setup>
import FormSection from '@/Components/Common/FormSection.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import { useToast } from 'vue-toastification'

import { useUser } from '@/helpers'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import InputError from '@/Components/Form/InputError.vue'

const toast = useToast()
const user = useUser()
const form = useForm({
  name: user.name,
  email: user.email
})

const submit = () =>
  form.put('/user/profile-information', {
    preserveScroll: true,
    onSuccess() {
      toast.success('Profile info updated.')
    }
  })
</script>
