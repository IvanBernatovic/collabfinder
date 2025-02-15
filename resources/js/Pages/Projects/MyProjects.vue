<template>
  <div class="py-6 sm:flex gap-5">
    <div class="sm:w-2/5 sm:mt-[70px] flex flex-col side-links">
      <InertiaLink
        href="/my-projects"
        class="side-link"
        :class="{ active: $page.url === '/my-projects' }"
        >My projects</InertiaLink
      >
      <InertiaLink
        href="/my-projects?section=saved"
        :class="{ active: $page.url === '/my-projects?section=saved' }"
        class="side-link"
        >Saved projects</InertiaLink
      >
    </div>

    <div class="sm:w-3/5">
      <div class="py-4 flex justify-between items-center">
        <h2 class="text-darkgrey text-lg font-semibold">My projects</h2>

        <InertiaLink
          href="/projects/create"
          class="px-3 py-2 flex items-center gap-2 font-medium border border-gray-300 text-darkgrey rounded-md"
        >
          <svg
            width="12"
            height="14"
            viewBox="0 0 12 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M2.276 9.66689L9.03733 2.90555L8.09467 1.96288L1.33333 8.72422V9.66689H2.276ZM2.82867 11.0002H0V8.17155L7.62333 0.548218C7.74835 0.423238 7.91789 0.353027 8.09467 0.353027C8.27144 0.353027 8.44098 0.423238 8.566 0.548218L10.452 2.43422C10.577 2.55924 10.6472 2.72878 10.6472 2.90555C10.6472 3.08233 10.577 3.25187 10.452 3.37689L2.82867 11.0002ZM0 12.3336H12V13.6669H0V12.3336Z"
              fill="#495057"
            />
          </svg>
          Create new project
        </InertiaLink>
      </div>

      <div class="flex flex-col">
        <Project
          v-if="projects.length"
          v-for="project in projects"
          :key="project.id"
          :project="project"
          :saved="project.id in savedProjects"
          :hide-saved="true"
          back-link="/my-projects"
          @delete-project="deleteProject"
        />

        <div v-else>You have no projects yet.</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link as InertiaLink, router } from '@inertiajs/vue3'

import Project from '@/Components/Projects/Project.vue'

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
  page: {}
})

const deleteProject = async project => {
  router.delete(`/projects/${project.id}`)
}
</script>
