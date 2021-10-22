<script>
import AppLayout from './../../Layouts/AppLayout'
import ProjectItem from 'Components/Projects/ProjectItem'
import ApplicationModal from 'Components/Projects/ApplicationModal'

export default {
  name: 'ProjectsShowPage',
  metaInfo() {
    return {
      title: 'Project'
    }
  },
  props: {
    project: Object,
    applications: Array
  },
  components: {
    AppLayout,
    ProjectItem,
    ApplicationModal
  },
  data() {
    return {
      applyingForProject: false,
      message: ''
    }
  },
  methods: {
    openContactModal() {
      this.message = ''
      this.applyingForProject = true
    },
    closeContactModal() {
      this.applyingForProject = false
    },
    applyForProject() {
      this.$inertia.post(
        `/projects/${this.project.id}/apply`,
        {
          message: this.message
        },
        {
          preserveScroll: true
        }
      )

      this.closeContactModal()
    }
  }
}
</script>

<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ project.name }}
      </h2>
    </template>

    <div class="py-5 lg:py-10">
      <div class="max-w-4xl mx-auto sm:px-6 md:px-8">
        <application-modal
          :show="applyingForProject"
          :message.sync="message"
          @close="closeContactModal"
          @apply-for-project="applyForProject"
        />

        <project-item
          :project="project"
          :applications="applications"
          :current-user="$page.props.user"
          @contact-button-clicked="openContactModal"
        />
      </div>
    </div>
  </app-layout>
</template>
