<script>
import styled from "vue-styled-components";
import { InertiaLink } from "@inertiajs/inertia-vue";
import JetButton from "Jetstream/Button";
import dayjs from "../../dayjs";

const ProjectItemWrapper = styled.div``;
const ProjectItemHeader = styled.div``;
const ProjectItemDescription = styled.div``;
const ProjectItemLookingForSection = styled.section``;
const ProjectItemTags = styled.section``;
const ProjectItemH3 = styled.h3``;
const ProjectItemTagsInnerWrapper = styled.div``;
const ProjectItemRolesInnerWrapper = styled.div``;
const Tag = styled.span``;
const Role = styled.span``;
const StyledHeader = styled.h3``;
const EditProjectLink = styled(InertiaLink);
const ContactButtonWrapper = styled.div``;
const ContactButton = styled.button``;
const ProjectItemCreatedByWrapper = styled.div``;
const ProjectItemDate = styled.span``;
const ProjectItemName = styled.span``;

export default {
  name: "ProjectItem",
  props: {
    project: Object,
    applications: {
      type: Array,
      default: () => [],
    },
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
    StyledHeader,
    EditProjectLink,
    ContactButtonWrapper,
    ContactButton,
    ProjectItemCreatedByWrapper,
    ProjectItemDate,
    ProjectItemName,
  },
  methods: {
    formattedTimestamp(timestamp) {
      return dayjs(timestamp).fromNow();
    },
  },
};
</script>

<template>
  <project-item-wrapper class="bg-white rounded-lg p-10 mb-10 shadow-lg">
    <project-item-header class="flex justify-between items-center">
      <styled-header class="font-bold text-2xl text-gray-00 leading-tight mb-2">
        {{ project.name }}
      </styled-header>

      <edit-project-link
        class="font-bold"
        :href="`/projects/${project.id}/edit`"
        v-if="project.user_id === $page.props.user.id"
        >Edit</edit-project-link
      >
    </project-item-header>

    <project-item-description>{{
      project.description
    }}</project-item-description>

    <project-item-looking-for-section>
      <project-item-h3 class="font-bold mt-4">I'm looking for</project-item-h3>
      <project-item-roles-inner-wrapper class="pt-1 -mb2-2">
        <role
          class="inline-block bg-blue-800 rounded-lg py-1 px-2 text-white mr-2 mb-2"
          v-for="role in project.roles"
          :key="'project-' + project.id + '_role-' + role.id"
          >{{ role.title }}
        </role>
      </project-item-roles-inner-wrapper>
    </project-item-looking-for-section>

    <project-item-tags>
      <project-item-h3 class="font-bold mt-4">Tags</project-item-h3>
      <project-item-tags-inner-wrapper class="pt-1 -mb-2">
        <tag
          class="bg-gray-200 rounded-lg py-1 px-2 mr-2 inline-block mb-2"
          v-for="tag in project.tags"
          :key="'project-' + project.id + '_tag-' + tag.id"
          >{{ tag.name }}</tag
        >
      </project-item-tags-inner-wrapper>
    </project-item-tags>

    <contact-button-wrapper class="mt-4">
      <contact-button
        class="px-4 py-2 bg-gradient-to-r from-blue-600 via-blue-800 to-teal-500 text-white rounded font-semibold uppercase"
        @click="$emit('contact-button-clicked', project)"
        :disabled="
          applications.includes(project.id) ||
          project.user_id === $page.props.user.id
        "
      >
        Contact
      </contact-button>
    </contact-button-wrapper>

    <project-item-created-by-wrapper class="mt-8">
      By
      <project-item-name class="font-semibold text-blue-800">{{
        project.user.name
      }}</project-item-name>
      <project-item-date class="text-gray-500">{{
        formattedTimestamp(project.created_at)
      }}</project-item-date>
    </project-item-created-by-wrapper>
  </project-item-wrapper>
</template>