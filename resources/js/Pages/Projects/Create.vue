<template>
  <div class="py-4 lg:w-2/3 mx-auto">
    <div class="bg-white rounded-lg card-shadow">
      <div class="p-6 border-b border-gray-200">
        <h1 class="text-xl font-semibold">Create project</h1>
      </div>
      <FormV2 :roles="roles" :tags="tags" @project-submit="submitNewProject">
        <template v-slot:footer>
          <div class="p-6 flex gap-2">
            <PrimaryButton type="submit">Save project</PrimaryButton>
            <Link class="secondary-btn" href="/projects">Cancel</Link>
          </div>
        </template>
      </FormV2>
    </div>
  </div>
</template>

<script setup>
import { toRefs } from 'vue'
import { Link } from '@inertiajs/vue3'

import FormV2 from '@/Components/Projects/FormV2.vue'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'

const props = defineProps(['roles', 'tags'])

const { roles, tags } = toRefs(props)

const submitNewProject = form => {
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
    .post('/projects', {
      preserveScroll: true,
      resetOnSuccess: false
    })
}
</script>

<style lang="postcss">
.card-shadow {
  box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1), 0px 4px 20px rgba(0, 0, 0, 0.15);
}
</style>
