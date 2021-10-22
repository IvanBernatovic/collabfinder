<template>
  <div class="py-8">
    <new-filters
      :roles="roles"
      :tags="tags"
      v-model:period="filters.period"
      v-model:selected-roles="filters.roles"
      v-model:selected-tags="filters.tags"
      @apply-filters="applyFilters"
    />
  </div>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import NewFilters from '@/Components/Projects/NewFilters.vue'
import { removeFalsy } from '@/helpers'

export default {
  components: { NewFilters },
  layout: Layout,
  props: {
    projects: Array,
    roles: {
      type: Array,
      default: () => []
    },
    tags: {
      type: Array,
      default: () => []
    }
  },
  created() {
    this.setInitFiltersFromUrl()
  },
  data() {
    return {
      filters: {
        roles: [],
        tags: [],
        period: null
      }
    }
  },
  methods: {
    setInitFiltersFromUrl() {
      const url = new URL(window.location)
      const roles = url.searchParams
        .getAll('roles[]')
        .map(roleId => parseInt(roleId))

      this.filters.roles = roles

      const tags = url.searchParams
        .getAll('tags[]')
        .map(tagId => parseInt(tagId))
      this.filters.tags = tags
      this.filters.period = url.searchParams.get('period')
    },
    applyFilters() {
      this.$inertia.get('/projects', removeFalsy(this.filters))
    }
  }
}
</script>
