<template>
  <div class="py-4 lg:w-2/3 mx-auto">
    <div class="p-6 bg-white rounded-lg">
      <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold">{{ project.name }}</h1>
        <div class="flex gap-2">
          <Link
            class="actions-btn"
            :href="`/projects/${project.id}/edit`"
            v-if="isOwner"
          >
            <PencilIcon class="w-4 h-4 text-[#5C5F62]" />
          </Link>
          <button class="actions-btn">
            <ShareIcon class="w-4 h-4 text-[#5C5F62]" />
          </button>
        </div>
      </div>

      <div class="flex justify-between gap-3 items-center mt-6">
        <p class="flex items-center mt-1">
          <svg
            v-if="project.roles.length === 1"
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="#51CF66"
          >
            <path
              fill-rule="evenodd"
              d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
              clip-rule="evenodd"
            />
          </svg>

          <svg
            v-if="project.roles.length > 1"
            xmlns="http://www.w3.org/2000/svg"
            className="h-10 w-10"
            viewBox="0 0 20 20"
            fill="#51CF66"
            height="22px"
            width="22px"
          >
            <path
              d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"
            />
          </svg>

          <span class="ml-2">{{
            project.roles.map(role => role.title).join(', ')
          }}</span>
        </p>

        <div>
          <span>{{ project.user.name }},</span> <span>{{ createdAtDiff }}</span>
        </div>
      </div>

      <div class="flex gap-2 mt-6">
        <PrimaryButton
          class="flex-1 font-medium rounded"
          @click="openModal"
          :disabled="applyDisabled"
          >{{ applyBtnLabel }}</PrimaryButton
        >
        <SecondaryButton class="flex-1" @click="toggleSave">{{
          saved ? 'Unsave' : 'Save'
        }}</SecondaryButton>
      </div>

      <div class="mt-8">
        <h2 class="font-semibold text-lg">Description</h2>

        <article
          class="text-gray-800 description"
          v-html="project.description"
        ></article>
      </div>

      <div class="mt-4" v-if="project.tags.length">
        <h2 class="font-semibold text-lg">Tags</h2>
        <div class="flex flex-wrap gap-2 mr-3">
          <div
            class="bg-[#f1f1f1] text-[#3d3d3d] font-light px-2 py-0.5 rounded"
            v-for="tag in project.tags"
            :key="tag.id"
          >
            {{ tag.name }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <ProjectModal :isOpen="isOpen" @apply="apply" @close="closeModal" />
</template>

<script>
import Layout from '@/Layouts/Layout.vue'

export default {
  layout: Layout
}
</script>

<script setup>
import { ShareIcon, PencilIcon } from '@heroicons/vue/outline'
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import dayjs from '@/dayjs'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import SecondaryButton from '@/Components/Common/SecondaryButton.vue'
import ProjectModal from '@/Components/Projects/ProjectModal.vue'

const {
  project,
  applied,
  saved: savedProp
} = defineProps({
  project: Object,
  applied: Boolean,
  saved: Boolean
})

const isOpen = ref(false)
const saved = ref(savedProp)

const createdAtDiff = dayjs(project.created_at).fromNow()
const user = usePage().props.value.user

const isOwner = project.user.id === user.id
const applyDisabled = applied || isOwner

const closeModal = () => {
  isOpen.value = false
}

const openModal = () => {
  isOpen.value = true
}

const apply = form => {
  form.post(`/projects/${project.id}/apply`)

  closeModal()
}

const toggleSave = async () => {
  await axios.post(`/projects/${project.id}/save`)

  saved.value = !saved.value
}

const getApplyLabel = () => {
  if (isOwner) {
    return 'You own this'
  }

  if (applied) {
    return 'Applied'
  }

  return 'Apply now'
}

const applyBtnLabel = getApplyLabel()
</script>

<style lang="postcss" scoped>
.actions-btn {
  @apply text-black p-2 rounded-lg box-border border border-gray-500 hover:cursor-pointer;
}

:deep .description {
  ul {
    @apply list-disc ml-4;
  }

  ol {
    @apply list-decimal ml-4;
  }
}
</style>
