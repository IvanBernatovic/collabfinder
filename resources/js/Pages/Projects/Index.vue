<template>
  <div class="py-8">
    <div class="flex justify-between items-center mb-6">
      <div>
        Showing:
        <span class="text-primary font-medium">{{ projects.length }} projects</span>
      </div>

      <DateFilter v-model="filters.period" @search="applyFilters" />
    </div>

    <div class="sm:flex gap-6">
      <div class="sm:w-2/5">
        <NewFilters :roles="roles" :tags="tags" v-model:period="filters.period" v-model:selected-roles="filters.roles"
          v-model:selected-tags="filters.tags" @apply-filters="applyFilters" />
      </div>
      <div class="sm:w-3/5">
        <div>
          <Project v-for="project in projects" :key="project.id" :project="project" :saved="project.id in savedProjects"
            @save-project="saveProject" @delete-project="deleteProject" />

          <NoResults v-if="!projects.length" />

          <SimplePagination v-if="links.nextUrl || links.previousUrl" :next-url="links.nextUrl"
            :previous-url="links.previousUrl" />
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
import { router } from '@inertiajs/vue3'

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
  },
  pageFilters: Object
})

const {
  projects: projectsProps,
  roles,
  tags,
  links,
  savedProjects: savedProjectsProp,
  pageFilters
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
  filters.roles = pageFilters.value.roles?.map(id => parseInt(id, 10)) || []
  filters.tags = pageFilters.value.tags?.map(id => parseInt(id, 10)) || []
  filters.period = url.searchParams.get('period')
}

const applyFilters = () => {
  router.get('/projects', removeFalsy(filters))
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

const deleteProject = async project => {
  router.delete(`/projects/${project.id}`, {
    onSuccess() {
      toast.success('Project deleted.')
    }
  })
}

onMounted(() => {
  setInitFiltersFromUrl()
})
</script>
