<template>
  <form-section @submitted="updateNotificationSettings">
    <template #title>Notifications settings </template>

    <p class="text-darkgrey dark:text-gray-300">
      Receive weekly emails about new projects for selected filters.
    </p>

    <form @submit.prevent="() => updateNotificationSettings()">
      <div class="form-group mt-6">
        <label for="roles" class="form-label">Roles</label>
        <USelectMenu size="lg" v-model="form.roles" :items="roles.map(({ id, title }) => ({ id, title }))"
          label-key="title" :multiple="true" placeholder="Search by roles" />

        <input-error :message="form.errors?.roles" />
      </div>

      <div class="form-group mt-4">
        <label for="tags" class="form-label">Tags</label>
        <USelectMenu size="lg" v-model="form.tags" :items="tags.map(({ id, name }) => ({ id, name }))" :multiple="true"
          label-key="name" placeholder="Search by tags" />

        <input-error :message="form.errors?.tags" />
      </div>

      <div class="mt-6 flex gap-2">
        <primary-button type="submit" :disabled="form.processing || (!form.roles.length && !form.tags.length)
          ">Subscribe</primary-button>
        <button class="secondary-btn" type="button" @click="unsubscribeFromAll">
          Reset
        </button>
      </div>
    </form>
  </form-section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

import FormSection from '@/Components/Common/FormSection.vue'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import InputError from '@/Components/Form/InputError.vue'

const props = defineProps(['roles', 'tags', 'notificationSettings'])

const form = useForm({
  roles: [...props.notificationSettings.roles.map(({ id, title }) => ({ id, title }))],
  tags: [...props.notificationSettings.tags.map(({ id, name }) => ({ id, name }))]
})

const toast = useToast()

const updateNotificationSettings = (reset = false) => {
  form
    .transform(data => ({
      roles: data.roles.map(role => role.id),
      tags: data.tags.map(tag => tag.id)
    }))
    .post('/settings/email-notifications', {
      preserveScroll: true
    })

  if (reset) {
    toast.success('Reset subscription filters.')
  } else {
    toast.success('Subscribed to selected filters.')
  }
}

const unsubscribeFromAll = () => {
  form.roles = []
  form.tags = []

  updateNotificationSettings(true)
}
</script>
