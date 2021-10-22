<template>
  <div class="bg-white rounded-md p-4 shadow-xl">
    <div class="flex gap-4">
      <Multiselect
        v-model="selectedRoles"
        @input="$emit('update:selectedRoles', $event)"
        :options="roles"
        valueProp="id"
        trackBy="title"
        label="title"
        mode="tags"
        :searchable="true"
        placeholder="Search by roles"
      />

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
      />

      <PrimaryButton @click="$emit('apply-filters')">Search</PrimaryButton>
    </div>

    <div class="pt-6">
      <DateFilter v-model="periodModel" @search="$emit('applyFilters')" />
    </div>
  </div>
</template>

<script>
import Multiselect from '@/Components/Form/Multiselect.vue'
import PrimaryButton from 'Components/Common/PrimaryButton'
import DateFilter from 'Components/Common/DateFilter.vue'

export default {
  components: {
    Multiselect,
    PrimaryButton,
    DateFilter
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
