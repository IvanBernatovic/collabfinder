<script>
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'

import JetButton from 'Jetstream/Button'
import JetSecondaryButton from 'Jetstream/SecondaryButton'

export default {
  props: ['roles', 'tags', 'selectedRoles', 'selectedTags'],
  components: {
    JetButton,
    JetSecondaryButton,
    Multiselect
  },
  methods: {
    subscribeToFilters() {
      axios.post('/settings/email-notifications', {
        roles: this.selectedRoles.map(item => item.id),
        tags: this.selectedTags.map(item => item.id)
      })
    }
  }
}
</script>

<template>
  <div class="bg-white rounded p-6 mb-6 shadow-md">
    <h2 class="mb-1 font-bold">Filter projects by roles and tags</h2>
    <div class="lg:flex lg:-mx-2">
      <div class="flex-1 lg:mx-2">
        <multiselect
          :value="selectedRoles"
          @input="$emit('update:selectedRoles', $event)"
          :options="roles"
          :multiple="true"
          label="title"
          track-by="id"
          placeholder="Select roles"
        />
      </div>

      <div class="flex-1 mt-2 lg:mx-2 lg:mt-0">
        <multiselect
          :value="selectedTags"
          @input="$emit('update:selectedTags', $event)"
          :options="tags"
          :multiple="true"
          label="name"
          track-by="id"
          placeholder="Select tags"
        />
      </div>
    </div>

    <div class="flex justify-between mt-2">
      <div>
        <jet-button
          @click.native="$emit('apply-filters')"
          type="primary"
          :disabled="!(selectedRoles.length || selectedTags.length)"
          >Search</jet-button
        >

        <inertia-link href="/projects">
          <jet-secondary-button type="primary" class="ml-2"
            >Reset filters</jet-secondary-button
          >
        </inertia-link>
      </div>

      <jet-secondary-button
        type="primary"
        class="ml-2"
        @click.native="subscribeToFilters"
        >Subscribe to these filters</jet-secondary-button
      >
    </div>
  </div>
</template>
