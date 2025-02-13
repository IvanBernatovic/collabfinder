<template>
  <form-section @submitted="updateNotificationSettings">
    <template #title>Notifications settings </template>

    <p class="text-darkgrey">
      Receive weekly emails about new projects for selected filters.
    </p>

    <form @submit.prevent="() => updateNotificationSettings()">
      <div class="form-group mt-6">
        <label for="roles" class="form-label">Roles</label>
        <multiselect
          v-model="form.roles"
          :options="roles"
          valueProp="id"
          trackBy="title"
          label="title"
          mode="tags"
          :searchable="true"
          :hideSelected="false"
          :closeOnSelect="false"
          placeholder="Search by roles"
          :caret="false"
          :object="true"
        />

        <input-error :message="form.errors?.roles" />
      </div>

      <div class="form-group mt-4">
        <label for="tags" class="form-label">Tags</label>
        <multiselect
          v-model="form.tags"
          :options="tags"
          mode="tags"
          valueProp="id"
          trackBy="name"
          label="name"
          :searchable="true"
          placeholder="Search by tags"
          :caret="false"
          :closeOnSelect="false"
          :hideSelected="false"
          :object="true"
        />

        <input-error :message="form.errors?.tags" />
      </div>

      <div class="mt-6 flex gap-2">
        <primary-button
          type="submit"
          :disabled="
            form.processing || (!form.roles.length && !form.tags.length)
          "
          >Subscribe</primary-button
        >
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

import Multiselect from '@/Components/Form/Multiselect.vue'
import FormSection from '@/Components/Common/FormSection.vue'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import InputError from '@/Components/Form/InputError.vue'

const props = defineProps(['roles', 'tags', 'notificationSettings'])

const form = useForm({
  roles: [...props.notificationSettings.roles],
  tags: [...props.notificationSettings.tags]
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
