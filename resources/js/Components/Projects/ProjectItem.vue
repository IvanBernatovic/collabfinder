<script>
import styled from 'vue-styled-components'
import { InertiaLink } from '@inertiajs/inertia-vue'
import JetButton from 'Jetstream/Button'
import dayjs from '../../dayjs'

const ProjectItemWrapper = styled.div``
const ProjectItemHeader = styled.div``
const ProjectItemDescription = styled.div``
const ProjectItemLookingForSection = styled.section``
const ProjectItemTags = styled.section``
const ProjectItemH3 = styled.h3``
const ProjectItemTagsInnerWrapper = styled.div``
const ProjectItemRolesInnerWrapper = styled.div``
const Tag = styled.div``
const Role = styled.div``
const EditProjectLink = styled(InertiaLink)``
const ContactButtonWrapper = styled.div``
const ContactButton = styled(JetButton)``
const ProjectItemCreatedByWrapper = styled.div``
const ProjectItemDate = styled.span``
const ProjectItemName = styled.span``

export default {
  name: 'ProjectItem',
  props: {
    project: Object,
    applications: {
      type: Array,
      default: () => []
    },
    currentUser: {
      type: Object
    }
  },
  components: {
    JetButton,
    ProjectItemWrapper,
    ProjectItemHeader,
    ProjectItemDescription,
    ProjectItemLookingForSection,
    ProjectItemTags,
    ProjectItemH3,
    ProjectItemTagsInnerWrapper,
    ProjectItemRolesInnerWrapper,
    Tag,
    Role,
    EditProjectLink,
    ContactButtonWrapper,
    ContactButton,
    ProjectItemCreatedByWrapper,
    ProjectItemDate,
    ProjectItemName
  },
  methods: {
    formattedTimestamp(timestamp) {
      return dayjs(timestamp).fromNow()
    }
  },
  computed: {
    applied() {
      return this.applications.includes(this.project.id)
    },
    isOwner() {
      return this.project.user_id === this.currentUser.id
    },
    contactButtonLabel() {
      if (this.applied) {
        return 'Applied'
      }

      if (this.isOwner) {
        return 'You own this'
      }

      return 'Contact'
    }
  }
}
</script>

<template>
  <project-item-wrapper class="bg-white rounded-lg p-8 md:p-10 mb-10 shadow-lg">
    <project-item-header
      class="flex flex-col-reverse md:flex-row justify-between items-center mb-2"
    >
      <inertia-link
        class="font-bold text-2xl text-gray-00 leading-tight hover:underline mb-2"
        :href="`/projects/${project.id}`"
        >{{ project.name }}</inertia-link
      >

      <edit-project-link
        class="ml-auto md:ml-0 font-bold px-3 py-2 rounded-md hover:bg-gray-100 transition-colors duration-100"
        :href="`/projects/${project.id}/edit`"
        v-if="project.user_id === currentUser.id"
        >Edit</edit-project-link
      >
    </project-item-header>

    <project-item-description class="whitespace-pre-wrap">{{
      project.description
    }}</project-item-description>

    <project-item-looking-for-section>
      <project-item-h3 class="font-bold mt-4">Roles needed</project-item-h3>
      <project-item-roles-inner-wrapper class="pt-1 -mb-2 flex flex-wrap">
        <role
          class="inline-block bg-indigo-600 rounded-md py-1 px-2 text-white mr-2 mb-2"
          v-for="role in project.roles"
          :key="'project-' + project.id + '_role-' + role.id"
          >{{ role.title }}
        </role>
      </project-item-roles-inner-wrapper>
    </project-item-looking-for-section>

    <project-item-tags>
      <project-item-h3 class="font-bold mt-2">Tags</project-item-h3>
      <project-item-tags-inner-wrapper class="pt-1 -mb-2 flex flex-wrap">
        <tag
          class="bg-gray-200 rounded-md py-1 px-2 mr-2 inline-block mb-2"
          v-for="tag in project.tags"
          :key="'project-' + project.id + '_tag-' + tag.id"
          >{{ tag.name }}</tag
        >
      </project-item-tags-inner-wrapper>
    </project-item-tags>

    <contact-button-wrapper class="mt-8">
      <contact-button
        @click.native="$emit('contact-button-clicked', project)"
        :disabled="applied || isOwner"
      >
        {{ contactButtonLabel }}
      </contact-button>
    </contact-button-wrapper>

    <project-item-created-by-wrapper class="mt-8">
      By
      <project-item-name class="font-semibold text-indigo-500">{{
        project.user.name
      }}</project-item-name>
      <project-item-date class="text-gray-500">{{
        formattedTimestamp(project.created_at)
      }}</project-item-date>
    </project-item-created-by-wrapper>
  </project-item-wrapper>
</template>
