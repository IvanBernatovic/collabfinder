<template>
  <div class="py-8">
    <div class="flex justify-between items-center mb-6">
      <div>
        Showing:
        <span class="text-primary font-medium"
          >{{ projects.length }} projects</span
        >
      </div>

      <DateFilter v-model="filters.period" @search="applyFilters" />
    </div>

    <div class="flex gap-6">
      <div class="w-2/5">
        <NewFilters
          :roles="roles"
          :tags="tags"
          v-model:period="filters.period"
          v-model:selected-roles="filters.roles"
          v-model:selected-tags="filters.tags"
          @apply-filters="applyFilters"
        />
      </div>
      <div class="w-3/5">
        <div>
          <Project
            v-for="project in projects"
            :key="project.id"
            :project="project"
          />

          <NoResults v-if="!projects.length" />

          <SimplePagination
            v-if="links.nextUrl || links.previousUrl"
            :next-url="links.nextUrl"
            :previous-url="links.previousUrl"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import NewFilters from '@/Components/Projects/NewFilters.vue'
import DateFilter from '@/Components/Common/DateFilter.vue'
import { removeFalsy } from '@/helpers'
import SimplePagination from '@/Components/Shared/SimplePagination.vue'
import Project from '@/Components/Projects/Project.vue'
import NoResults from '@/Components/Common/NoResults.vue'

export default {
  components: {
    NewFilters,
    DateFilter,
    SimplePagination,
    Project,
    NoResults
  },
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
    },
    links: Object
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
