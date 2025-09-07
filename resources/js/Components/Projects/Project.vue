<template>
  <div class="bg-white p-6 pb-4 border-b border-gray-200">
    <div class="flex justify-between items-start">
      <div class="mr-4">
        <InertiaLink class="font-semibold text-[15px] text-black hover:underline" :href="`/projects/${project.id}`">{{
          project.name }}
        </InertiaLink>
        <div class="flex mt-1 items-center">
          <div>
            <AcademicCapIcon class="h-6 w-6 text-[#51CF66]" />
          </div>

          <p class="ml-2">{{
            project.roles.map(role => role.title).join(', ')
            }}</p>
        </div>
      </div>

      <div class="actions">
        <button :title="!saved ? 'Save project' : 'Unsave project'" v-if="!hideSaved"
          @click="$emit('saveProject', project)">
          <BookmarkIcon class="w-4 h-4" v-if="!saved" />
          <BookmarkIconSolid class="w-4 h-4" v-if="saved" />
        </button>

        <InertiaLink :href="`/projects/${project.id}/edit`" :data="{ backLink }" v-if="project.user.id === user.id">
          <PencilIcon class="w-4 h-4" />
        </InertiaLink>

        <button v-if="project.user.id === user.id" @click="$emit('deleteProject', project)">
          <TrashIcon class="w-4 h-4" />
        </button>
      </div>
    </div>

    <div class="flex items-center justify-between mt-6">
      <div class="flex flex-wrap gap-2 mr-3">
        <div class="bg-[#f1f1f1] text-[#3d3d3d] font-light px-2 py-0.5 rounded" v-for="tag in project.tags"
          :key="tag.id">
          {{ tag.name }}
        </div>
      </div>

      <div class="text-sm text-gray-600">
        <span class="whitespace-nowrap text-sm">{{ createdAtDiff }}</span>
      </div>
    </div>

    <div class="mt-3 flex gap-3 items-center text-gray-500">
      <InertiaLink :href="`/projects/${project.id}#comments`"
        class="flex items-center hover:underline hover:cursor-pointer text-gray-500" title="Comments">
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
          </svg>

        </span>
        <span class="ml-1">{{ project.comments_count }}</span>
      </InertiaLink>

      <!-- Applicants -->
      <div class="flex items-center text-gray-500" title="Applicants">
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
          </svg>


        </span>
        <span class="ml-1">{{ project.applications_count }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link as InertiaLink } from '@inertiajs/vue3'
import { AcademicCapIcon, BookmarkIcon, PencilIcon, TrashIcon, UsersIcon } from '@heroicons/vue/outline'
import { BookmarkIcon as BookmarkIconSolid } from '@heroicons/vue/solid'


import dayjs from '@/dayjs'
import { useUser } from '@/helpers'

const props = defineProps({
  project: Object,
  saved: Boolean,
  hideSaved: {
    type: Boolean,
    default: false
  },
  user: Object,
  backLink: String
})

const user = useUser()

const createdAtDiff = dayjs(props.project.created_at).fromNow()
</script>

<style lang="postcss" scoped>
.actions {
  @apply flex gap-1.5;

  >* {
    @apply text-gray-500 border border-gray-200 rounded p-1.5;
  }
}
</style>
