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
            :saved="project.id in savedProjects"
            @save-project="saveProject"
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

export default {
  layout: Layout
}
</script>

<script setup>
import { toRefs, reactive, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'

import NewFilters from '@/Components/Projects/NewFilters.vue'
import DateFilter from '@/Components/Common/DateFilter.vue'
import { removeFalsy, useImmer } from '@/helpers'
import SimplePagination from '@/Components/Shared/SimplePagination.vue'
import Project from '@/Components/Projects/Project.vue'
import NoResults from '@/Components/Common/NoResults.vue'
import { useToast } from 'vue-toastification'

const props = defineProps({
  projects: Array,
  roles: {
    type: Array,
    default: () => []
  },
  tags: {
    type: Array,
    default: () => []
  },
  links: Object,
  savedProjects: {
    type: Array,
    default: () => []
  }
})

const {
  projects: projectsProps,
  roles,
  tags,
  links,
  savedProjects: savedProjectsProp
} = toRefs(props)

const [projects] = useImmer(projectsProps)
const [savedProjects, updateSaved] = useImmer(
  savedProjectsProp.value.reduce((res, id) => {
    res[id] = true

    return res
  }, {})
)

const filters = reactive({
  roles: [],
  tags: [],
  period: null
})

const toast = useToast()

const setInitFiltersFromUrl = () => {
  const url = new URL(window.location)
  const roles = url.searchParams
    .getAll('roles[]')
    .map(roleId => parseInt(roleId))

  filters.roles = roles

  const tags = url.searchParams.getAll('tags[]').map(tagId => parseInt(tagId))

  filters.tags = tags
  filters.period = url.searchParams.get('period')
}

const applyFilters = () => {
  Inertia.get('/projects', removeFalsy(filters))
}

const saveProject = async project => {
  await axios.post(`/projects/${project.id}/save`)

  if (project.id in savedProjects.value) {
    updateSaved(saved => {
      delete saved[project.id]
    })

    toast.success(`Removed "${project.name}" from saved.`)

    return
  }

  updateSaved(saved => {
    saved[project.id] = true
  })

  toast.success(`Saved "${project.name}".`)

  return
}

onMounted(() => {
  setInitFiltersFromUrl()
})
</script>
