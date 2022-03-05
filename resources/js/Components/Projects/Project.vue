<template>
  <div class="bg-white p-6 border-b border-gray-200">
    <div class="flex justify-between items-start">
      <div class="mr-4">
        <InertiaLink
          class="font-semibold text-[15px] text-black hover:underline"
          :href="`/projects/${project.id}`"
          >{{ project.name }}</InertiaLink
        >
        <!-- <span class="text-sm text-gray-800">{{
                  project.user.name
                }}</span> -->

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
      </div>

      <button class="text-gray-500 border border-gray-200 rounded p-1.5">
        <BookmarkIcon class="w-4 h-4" />
      </button>
    </div>

    <div class="flex items-center justify-between mt-6">
      <div class="flex flex-wrap gap-2 mr-3">
        <div
          class="bg-[#f1f1f1] text-[#3d3d3d] font-light px-2 py-0.5 rounded"
          v-for="tag in project.tags"
          :key="tag.id"
        >
          {{ tag.name }}
        </div>
      </div>

      <div class="text-sm text-gray-600">
        <span class="whitespace-nowrap text-sm">{{ createdAtDiff }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

import dayjs from '@/dayjs'
import { InertiaLink } from '@inertiajs/inertia-vue3'
import { BookmarkIcon } from '@heroicons/vue/outline'

const props = defineProps({
  project: Object
})

const createdAtDiff = computed(() => dayjs(props.project.created_at).fromNow())
</script>
