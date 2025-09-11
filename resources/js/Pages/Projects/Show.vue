<template>
  <div class="py-4 lg:w-2/3 mx-auto ">
    <div class="p-6 bg-white dark:bg-gray-900 rounded-lg">
      <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold">{{ project.name }}</h1>
        <div class="flex gap-2 text-[#5C5F62] dark:text-gray-50">
          <Link class="actions-btn" :href="`/projects/${project.id}/edit`" v-if="isOwner">
          <PencilIcon class="w-4 h-4" />
          </Link>

          <ShareProjectPopover :project="project" />
        </div>
      </div>

      <div class="flex justify-between gap-3 items-center mt-6">
        <p class="flex items-center mt-1">
          <svg v-if="project.roles.length === 1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
            fill="#51CF66">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
          </svg>

          <svg v-if="project.roles.length > 1" xmlns="http://www.w3.org/2000/svg" className="h-10 w-10"
            viewBox="0 0 20 20" fill="#51CF66" height="22px" width="22px">
            <path
              d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
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
        <PrimaryButton class="flex-1 font-medium rounded-sm" @click="openModal" :disabled="applyDisabled">{{
          applyBtnLabel
          }}
        </PrimaryButton>
        <SecondaryButton class="flex-1" @click="toggleSave">{{
          saved ? 'Unsave' : 'Save'
        }}</SecondaryButton>
      </div>

      <div class="mt-8">
        <h2 class="font-semibold text-lg">Description</h2>

        <article class="text-gray-800 dark:text-gray-50 description" v-html="project.description"></article>
      </div>

      <div class="mt-4" v-if="project.tags.length">
        <h2 class="font-semibold text-lg">Tags</h2>
        <div class="flex flex-wrap gap-2 mr-3">
          <div
            class="bg-[#f1f1f1] dark:bg-gray-700 text-[#3d3d3d] dark:text-gray-100 font-light dark:font-normal px-2 py-0.5 rounded-sm"
            v-for="tag in project.tags" :key="tag.id">
            {{ tag.name }}
          </div>
        </div>
      </div>
    </div>

    <!-- Comments Section -->
    <div class="mt-6 p-6 bg-white dark:bg-gray-900 rounded-lg">
      <CommentList :comments="commentsData" :project-id="project.id" :comments-count="project.comments_count"
        @comment-added="handleCommentAdded" @comment-deleted="handleCommentDeleted" />
    </div>
  </div>

  <ProjectModal :isOpen="isOpen" @apply="apply" @close="closeModal" />
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import ShareProjectPopover from './ShareProjectPopover.vue'

export default {
  layout: Layout
}
</script>

<script setup>
import { PencilIcon } from '@heroicons/vue/outline'
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { useToast } from 'vue-toastification'

import dayjs from '@/dayjs'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import SecondaryButton from '@/Components/Common/SecondaryButton.vue'
import ProjectModal from '@/Components/Projects/ProjectModal.vue'
import CommentList from '@/Components/Comments/CommentList.vue'

const props = defineProps({
  project: Object,
  applied: Boolean,
  saved: Boolean,
  comments: Array,
})

const isOpen = ref(false)
const saved = ref(props.saved)
const commentsData = ref(props.comments || [])
const project = props.project

const createdAtDiff = dayjs(project.created_at).fromNow()
const user = usePage().props.auth.user
const toast = useToast()

const isOwner = project.user.id === user.id
const applyDisabled = computed(() => props.applied || isOwner)

const closeModal = () => {
  isOpen.value = false
}

const openModal = () => {
  isOpen.value = true
}

const apply = form => {
  form.post(`/projects/${project.id}/apply`, {
    onSuccess: () => {
      closeModal()
      toast.success('Applied for project. The project owner will be contacted.')
    }
  })
}

const toggleSave = async () => {
  await axios.post(`/projects/${project.id}/save`)

  saved.value = !saved.value

  if (saved.value) {
    toast.success(`Saved "${project.name}".`)
  } else {
    toast.success(`Removed "${project.name}" from saved.`)
  }
}


const getApplyLabel = (isOwner, applied) => {
  if (isOwner) {
    return 'You own this'
  }

  if (applied) {
    return 'Applied'
  }

  return 'Apply now'
}

const applyBtnLabel = computed(() => getApplyLabel(isOwner, props.applied))

const handleCommentAdded = () => {
  // Refresh the page to get updated comments
  window.location.reload()
}

const handleCommentDeleted = (commentId) => {
  // Remove the deleted comment from the local state
  commentsData.value = commentsData.value.filter(comment => comment.id !== commentId)
}
</script>
