<script>
import ProjectItem from 'Components/Projects/ProjectItem'
import ApplicationModal from 'Components/Projects/ApplicationModal'
import SimplePagination from 'Components/Shared/SimplePagination'

export default {
  props: ['projects', 'applications', 'user', 'links'],
  data() {
    return {
      applyingForProject: false,
      project: null,
      message: ''
    }
  },
  components: {
    ProjectItem,
    SimplePagination,
    ApplicationModal
  },
  methods: {
    openContactModal(project) {
      this.project = project
      this.message = ''
      this.applyingForProject = true
    },
    closeContactModal() {
      this.applyingForProject = false
      this.project = null
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
  <div>
    <application-modal
      :show="applyingForProject"
      :message.sync="message"
      @close="closeContactModal"
      @apply-for-project="applyForProject"
    />

    <project-item
      v-for="(project, i) in projects"
      :key="`project-item-${i}`"
      :project="project"
      :applications="applications"
      :current-user="user"
      @contact-button-clicked="openContactModal"
    />

    <simple-pagination
      v-if="links.nextUrl || links.previousUrl"
      :next-url="links.nextUrl"
      :previous-url="links.previousUrl"
    />
  </div>
</template>
