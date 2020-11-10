<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create new project
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <ProjectForm :tags="tags" :roles="roles" @submit="submitNewProject" />
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "./../../Layouts/AppLayout";
import ProjectForm from "Components/Projects/Form";

export default {
  name: "CreateProject",
  props: ["tags", "roles"],
  components: {
    AppLayout,
    ProjectForm,
  },
  methods: {
    submitNewProject(form) {
      form.post("/projects", {
        preserveScroll: true,
        resetOnSuccess: false,
      });
    },
  },
};
</script>