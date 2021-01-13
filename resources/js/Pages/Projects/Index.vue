<script>
import styled from "vue-styled-components";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

import AppLayout from "./../../Layouts/AppLayout";
import JetButton from "Jetstream/Button";
import JetSecondaryButton from "Jetstream/SecondaryButton";
import JetDialogModal from "Jetstream/DialogModal";
import JetLabel from "Jetstream/Label";
import ProjectItem from "Components/Projects/ProjectItem";
import SimplePagination from "Components/Shared/SimplePagination";

const ProjectList = styled.div``;
const ProjectModal = styled(JetDialogModal)``;
const ProjectFilters = styled.div``;

export default {
  name: "ProjectsIndexPage",
  metaInfo() {
    return {
      title: "Projects",
    };
  },
  props: {
    projects: Array,
    applications: Array,
    roles: {
      type: Array,
      default: () => [],
    },
    tags: {
      type: Array,
      default: () => [],
    },
    links: Object,
  },
  components: {
    AppLayout,
    JetDialogModal,
    JetLabel,
    JetButton,
    JetSecondaryButton,
    ProjectList,
    ProjectModal,
    ProjectItem,
    ProjectFilters,
    Multiselect,
    SimplePagination,
  },
  mounted() {
    const url = new URL(window.location);
    const roles = url.searchParams
      .getAll("roles[]")
      .map((roleId) => parseInt(roleId));
    this.filters.roles = this.roles.filter((role) => roles.includes(role.id));

    const tags = url.searchParams
      .getAll("tags[]")
      .map((tagId) => parseInt(tagId));
    this.filters.tags = this.tags.filter((tag) => tags.includes(tag.id));
  },
  data() {
    return {
      applyingForProject: false,
      project: null,
      message: "",
      filters: {
        roles: [],
        tags: [],
      },
    };
  },
  methods: {
    openContactModal(project) {
      this.project = project;
      this.message = "";
      this.applyingForProject = true;
    },
    closeContactModal() {
      this.applyingForProject = false;
      this.project = null;
    },
    applyForProject() {
      this.$inertia.post(
        `/projects/${this.project.id}/apply`,
        {
          message: this.message,
        },
        {
          preserveScroll: true,
        }
      );

      this.closeContactModal();
    },
    applyFilters() {
      this.$inertia.get("/projects", this.parsedFilters);
    },
  },
  computed: {
    parsedFilters() {
      return {
        roles: this.filters.roles.map((role) => role.id),
        tags: this.filters.tags.map((tag) => tag.id),
      };
    },
  },
};
</script>

<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Projects
      </h2>
    </template>

    <div class="py-5 lg:py-10">
      <project-modal :show="applyingForProject" @close="closeContactModal">
        <template #title>
          <h1 class="font-bold">Contact OP</h1>
        </template>

        <template #content>
          <div>
            <jet-label for="message">Message</jet-label>
            <textarea
              class="form-input w-full"
              rows="5"
              name="message"
              id="message"
              v-model="message"
              required
              placeholder="I would like to be part of this project because..."
            ></textarea>
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click.native="closeContactModal">
            Cancel
          </jet-secondary-button>
          <jet-button
            type="submit"
            @click.native.prevent="applyForProject"
            :disabled="!message && message.length < 3"
            >Apply</jet-button
          >
        </template>
      </project-modal>

      <project-list class="max-w-4xl mx-auto sm:px-6 md:px-8">
        <project-filters class="bg-white rounded p-6 mb-6 shadow-md">
          <h2 class="mb-1 font-bold">Filter projects by roles and tags</h2>
          <div class="lg:flex lg:-mx-2">
            <div class="flex-1 lg:mx-2">
              <multiselect
                v-model="filters.roles"
                :options="roles"
                :multiple="true"
                label="title"
                track-by="id"
                placeholder="Select roles"
              />
            </div>

            <div class="flex-1 mt-2 lg:mx-2 lg:mt-0">
              <multiselect
                v-model="filters.tags"
                :options="tags"
                :multiple="true"
                label="name"
                track-by="id"
                placeholder="Select tags"
              />
            </div>
          </div>

          <jet-button
            @click.native="applyFilters"
            type="primary"
            class="mt-2"
            :disabled="!(filters.roles.length || filters.tags.length)"
            >Search</jet-button
          >

          <inertia-link href="/projects">
            <jet-secondary-button type="primary" class="mt-2 ml-2"
              >Reset filters</jet-secondary-button
            >
          </inertia-link>
        </project-filters>

        <project-item
          v-for="(project, i) in projects"
          :key="`project-item-${i}`"
          :project="project"
          :applications="applications"
          :current-user="$page.props.user"
          @contact-button-clicked="openContactModal"
        />

        <simple-pagination
          :next-url="links.nextUrl"
          :previous-url="links.previousUrl"
        />
      </project-list>
    </div>
  </app-layout>
</template>
