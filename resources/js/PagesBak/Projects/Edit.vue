<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit project
      </h2>
    </template>

    <div class="py-4 md:py-12">
      <div class="max-w-4xl mx-auto px-1 md:px-8">
        <ProjectForm
          :tags="tags"
          :roles="roles"
          :project="project"
          @submit="updateProject"
        />
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout'
import ProjectForm from 'Components/Projects/Form'

export default {
  name: 'Edit',
  metaInfo: {
    title: 'Edit project'
  },
  props: ['tags', 'roles', 'project'],
  components: {
    AppLayout,
    ProjectForm
  },
  methods: {
    updateProject(form) {
      form.put(`/projects/${this.project.id}`, {
        resetOnSuccess: false
      })
    }
  }
}
</script>
