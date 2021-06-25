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

    <jet-button
      @click.native="$emit('apply-filters')"
      type="primary"
      class="mt-2"
      :disabled="!(selectedRoles.length || selectedTags.length)"
      >Search</jet-button
    >

    <inertia-link href="/projects">
      <jet-secondary-button type="primary" class="mt-2 ml-2"
        >Reset filters</jet-secondary-button
      >
    </inertia-link>
  </div>
</template>
