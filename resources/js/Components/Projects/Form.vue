<template>
  <form @submit.prevent="$emit('submit', form)" autocomplete="off">
    <div class="bg-white rounded-md shadow-md">
      <div class="p-5 md:p-10">
        <div>
          <jet-label for="project_name">Name</jet-label>
          <jet-input
            v-model="form.name"
            name="project_name"
            id="project_name"
            class="w-full"
            autocomplete="off"
            list="autocompleteOff"
          />
          <jet-input-error :message="form.error('name')" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="description">Description</jet-label>
          <small class="text-xs text-gray-500"
            >To avoid idea theft keep this on a need-to-know basis</small
          >
          <textarea
            class="form-input w-full"
            rows="5"
            name="description"
            id="description"
            v-model="form.description"
          ></textarea>
          <jet-input-error :message="form.error('description')" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="roles">Roles</jet-label>
          <multiselect
            v-model="form.roles"
            :options="roles"
            :multiple="true"
            label="title"
            track-by="id"
          ></multiselect>

          <jet-input-error :message="form.error('roles')" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="tags">Tags</jet-label>
          <multiselect
            v-model="form.tags"
            :options="tags"
            :multiple="true"
            label="name"
            track-by="name"
            :taggable="true"
            @tag="addTag"
          ></multiselect>

          <jet-input-error :message="form.error('tags')" class="mt-2" />
        </div>

        <div class="block mt-4" v-if="!project">
          <label class="flex items-center">
            <input
              type="checkbox"
              class="form-checkbox"
              v-model="terms"
              name="terms"
            />
            <span class="ml-2 text-sm text-gray-600"
              >I agree that CollabFinder.net is not liable in case of idea theft
              as disclosed in
              <a href="/terms" class="text-indigo-700" target="_blank"
                >terms of service</a
              ></span
            >
          </label>
        </div>
      </div>

      <div
        class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6"
      >
        <jet-danger-button
          @click.native="deleteProject"
          class="mr-4"
          v-if="project"
          >Delete</jet-danger-button
        >
        <jet-button type="submit" :disabled="!terms && !project"
          >Publish</jet-button
        >
      </div>
    </div>
  </form>
</template>

<script>
import AppLayout from "./../../Layouts/AppLayout";
import JetInput from "Jetstream/Input";
import JetLabel from "Jetstream/Label";
import JetButton from "Jetstream/Button";
import JetDangerButton from "Jetstream/DangerButton";
import JetInputError from "Jetstream/InputError";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
  name: "ProjectForm",
  props: ["tags", "roles", "project"],
  components: {
    AppLayout,
    JetInput,
    JetLabel,
    JetButton,
    JetDangerButton,
    JetInputError,
    Multiselect,
  },
  data() {
    return {
      terms: false,
      form: this.$inertia.form(
        {
          name: this.project?.name || "",
          description: this.project?.description || "",
          roles: this.project?.roles || [],
          tags: this.project?.tags || [],
        },
        {
          resetOnSuccess: false,
        }
      ),
    };
  },
  methods: {
    deleteProject() {
      this.form.delete(`/projects/${this.project.id}`);
    },
    addTag(newTag) {
      const tag = {
        name: newTag,
      };
      this.tags.push(tag);
      this.form.tags.push(tag);
    },
  },
};
</script>