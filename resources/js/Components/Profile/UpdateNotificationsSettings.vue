<script>
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'

import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
  props: ['roles', 'tags', 'notificationSettings'],
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    Multiselect,
    JetSecondaryButton
  },
  data() {
    return {
      form: this.$inertia.form({
        selectedRoles: [...this.notificationSettings.roles],
        selectedTags: [...this.notificationSettings.tags]
      })
    }
  },
  methods: {
    updateNotificationSettings() {
      this.form
        .transform(data => {
          return {
            roles: data.selectedRoles.map(item => item.id),
            tags: data.selectedTags.map(item => item.id)
          }
        })
        .post('/settings/email-notifications', {
          preserveScroll: true
        })
    },
    unsubscribeFromAll() {
      this.form.selectedRoles = []
      this.form.selectedTags = []
      this.updateNotificationSettings()
    }
  }
}
</script>

<template>
  <jet-form-section @submitted="updateNotificationSettings">
    <template #title>Notifications settings </template>

    <template #description>
      Receive weekly emails about new projects for selected filters.
    </template>

    <template #form>
      <div class="lg:flex col-span-full col-gap-4">
        <multiselect
          class="mb-4 lg:mb-0"
          v-model="form.selectedRoles"
          :options="roles"
          :multiple="true"
          label="title"
          track-by="id"
          placeholder="Select roles"
        />

        <multiselect
          v-model="form.selectedTags"
          :options="tags"
          :multiple="true"
          label="name"
          track-by="id"
          placeholder="Select tags"
        />
      </div>
    </template>

    <template #actions>
      <jet-action-message :on="form.recentlySuccessful" class="mr-3">
        Saved.
      </jet-action-message>

      <jet-secondary-button
        @click.native="unsubscribeFromAll"
        class="mr-4"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Unsubscribe
      </jet-secondary-button>

      <jet-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </jet-button>
    </template>
  </jet-form-section>
</template>
