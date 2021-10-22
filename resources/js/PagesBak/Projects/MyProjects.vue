<script>
import AppLayout from './../../Layouts/AppLayout'

import ProjectFilters from 'Components/Projects/Filters'
import ProjectList from 'Components/Projects/List'

export default {
  name: 'MyProjectsPage',
  metaInfo() {
    return {
      title: 'MyProjects'
    }
  },
  props: {
    projects: Array,
    applications: Array,
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
  components: {
    AppLayout,
    ProjectFilters,
    ProjectList
  },
  mounted() {
    const url = new URL(window.location)
    const roles = url.searchParams
      .getAll('roles[]')
      .map(roleId => parseInt(roleId))
    this.filters.roles = this.roles.filter(role => roles.includes(role.id))

    const tags = url.searchParams.getAll('tags[]').map(tagId => parseInt(tagId))
    this.filters.tags = this.tags.filter(tag => tags.includes(tag.id))
  },
  data() {
    return {
      filters: {
        roles: [],
        tags: []
      }
    }
  },
  methods: {
    applyFilters() {
      this.$inertia.get('/projects', this.parsedFilters)
    }
  },
  computed: {
    parsedFilters() {
      return {
        roles: this.filters.roles.map(role => role.id),
        tags: this.filters.tags.map(tag => tag.id)
      }
    }
  }
}
</script>

<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        My Projects
      </h2>
    </template>

    <div class="py-5 lg:py-10">
      <div class="max-w-4xl mx-auto sm:px-6 md:px-8">
        <project-list
          :projects="projects"
          :applications="applications"
          :links="links"
          :user="$page.props.user"
        />
      </div>
    </div>
  </app-layout>
</template>
