<template>
  <div>
    <div class="bg-white rounded-md p-4 shadow-lg mb-10">
      <div class="mb-4">
        <label class="font-semibold mb-1 inline-block">Roles</label>
        <Multiselect
          v-model="selectedRoles"
          @input="$emit('update:selectedRoles', $event)"
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
        />
      </div>

      <div class="mb-4">
        <label for="" class="font-semibold mb-1 inline-block">Tags</label>
        <Multiselect
          v-model="selectedTags"
          @input="$emit('update:selectedTags', $event)"
          :options="tags"
          mode="tags"
          valueProp="id"
          trackBy="name"
          label="name"
          :searchable="true"
          :createTag="true"
          placeholder="Search by tags"
          :caret="false"
          :closeOnSelect="false"
          :hideSelected="false"
        />
      </div>

      <PrimaryButton @click="$emit('apply-filters')">Search</PrimaryButton>
    </div>
  </div>
</template>

<script>
import Multiselect from '@/Components/Form/Multiselect.vue'
import PrimaryButton from 'Components/Common/PrimaryButton'

export default {
  components: {
    Multiselect,
    PrimaryButton
  },
  props: {
    roles: {
      type: Array,
      default: () => []
    },
    tags: {
      type: Array,
      default: () => []
    },
    selectedRoles: Array,
    selectedTags: Array,
    period: String
  },
  created() {
    this.periodModel = this.period
  },
  data() {
    return {
      periodModel: null
    }
  },
  watch: {
    periodModel(val) {
      this.$emit('update:period', val)
    }
  }
}
</script>
