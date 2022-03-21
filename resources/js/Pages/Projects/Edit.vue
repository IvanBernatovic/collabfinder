<template>
  <div class="py-4 lg:w-2/3 mx-auto">
    <div class="bg-white rounded-lg card-shadow">
      <div class="p-6 border-b border-gray-200">
        <h1 class="text-xl font-semibold">Edit project</h1>
      </div>
      <FormV2
        :roles="roles"
        :tags="tags"
        :project="project"
        @project-submit="updateProject"
      >
        <template #footer="{ form }">
          <div class="p-6 flex gap-2">
            <PrimaryButton type="submit" :disabled="form.processing"
              >Update</PrimaryButton
            >
            <Link
              class="secondary-btn"
              :href="backLink || `/projects/${project.id}`"
              >Cancel</Link
            >
          </div>
        </template>
      </FormV2>
    </div>
  </div>
</template>

<script setup>
import { toRefs } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { useToast } from 'vue-toastification'

import FormV2 from '@/Components/Projects/FormV2.vue'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import { useParams } from '@/helpers'

const props = defineProps(['project', 'roles', 'tags'])

const { project, roles, tags } = toRefs(props)
const { backLink } = useParams()

const toast = useToast()

const updateProject = form => {
  form
    .transform(data => {
      return {
        ...data,
        tags: data.tags.map(tag => {
          if (Number.isInteger(tag.id)) {
            return tag
          }

          return {
            name: tag.name
          }
        })
      }
    })
    .put(`/projects/${props.project.id}`, {
      preserveScroll: true,
      resetOnSuccess: false,
      onSuccess() {
        toast.success('Project updated.')
      }
    })
}
</script>
