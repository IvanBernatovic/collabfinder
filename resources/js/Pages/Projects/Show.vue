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
          <Popover class="relative">
            <PopoverButton class="actions-btn">
              <ShareIcon class="w-4 h-4 text-[#5C5F62]" />
            </PopoverButton>
            <transition
              enter-active-class="transition duration-200 ease-out"
              enter-from-class="translate-y-1 opacity-0"
              enter-to-class="translate-y-0 opacity-100"
              leave-active-class="transition duration-150 ease-in"
              leave-from-class="translate-y-0 opacity-100"
              leave-to-class="translate-y-1 opacity-0"
            >
              <PopoverPanel
                class="mt-2 bg-white rounded-mdy px-3 py-4 absolute z-10 w-[250px] shadow right-0"
                v-slot="{ close }"
              >
                <div class="flex gap-2">
                  <ShareNetwork
                    network="twitter"
                    :url="projectLink"
                    :title="projectShareTitle"
                    class="social-icon-wrapper bg-[#1DA1F2]"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5"
                      viewBox="0 0 512 512"
                      fill="currentColor"
                    >
                      <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                      <path
                        d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                      />
                    </svg>
                  </ShareNetwork>

                  <ShareNetwork
                    network="facebook"
                    :url="projectLink"
                    :title="projectShareTitle"
                    :description="projectShareTitle"
                    class="social-icon-wrapper bg-[#4267B2]"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 320 512"
                      class="w-5 h-5"
                      fill="currentColor"
                    >
                      <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                      <path
                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                      />
                    </svg>
                  </ShareNetwork>

                  <ShareNetwork
                    network="linkedin"
                    :url="projectLink"
                    :title="projectShareTitle"
                    :description="projectShareTitle"
                    class="social-icon-wrapper bg-[#0A66C2]"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 448 512"
                      class="w-5 h-5"
                      fill="currentColor"
                    >
                      <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                      <path
                        d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"
                      />
                    </svg>
                  </ShareNetwork>

                  <ShareNetwork
                    network="reddit"
                    :url="projectLink"
                    :title="projectShareTitle"
                    :description="projectShareTitle"
                    class="social-icon-wrapper bg-[#FF5700]"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                      class="w-5 h-6"
                      fill="currentColor"
                    >
                      <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                      <path
                        d="M440.3 203.5c-15 0-28.2 6.2-37.9 15.9-35.7-24.7-83.8-40.6-137.1-42.3L293 52.3l88.2 19.8c0 21.6 17.6 39.2 39.2 39.2 22 0 39.7-18.1 39.7-39.7s-17.6-39.7-39.7-39.7c-15.4 0-28.7 9.3-35.3 22l-97.4-21.6c-4.9-1.3-9.7 2.2-11 7.1L246.3 177c-52.9 2.2-100.5 18.1-136.3 42.8-9.7-10.1-23.4-16.3-38.4-16.3-55.6 0-73.8 74.6-22.9 100.1-1.8 7.9-2.6 16.3-2.6 24.7 0 83.8 94.4 151.7 210.3 151.7 116.4 0 210.8-67.9 210.8-151.7 0-8.4-.9-17.2-3.1-25.1 49.9-25.6 31.5-99.7-23.8-99.7zM129.4 308.9c0-22 17.6-39.7 39.7-39.7 21.6 0 39.2 17.6 39.2 39.7 0 21.6-17.6 39.2-39.2 39.2-22 .1-39.7-17.6-39.7-39.2zm214.3 93.5c-36.4 36.4-139.1 36.4-175.5 0-4-3.5-4-9.7 0-13.7 3.5-3.5 9.7-3.5 13.2 0 27.8 28.5 120 29 149 0 3.5-3.5 9.7-3.5 13.2 0 4.1 4 4.1 10.2.1 13.7zm-.8-54.2c-21.6 0-39.2-17.6-39.2-39.2 0-22 17.6-39.7 39.2-39.7 22 0 39.7 17.6 39.7 39.7-.1 21.5-17.7 39.2-39.7 39.2z"
                      />
                    </svg>
                  </ShareNetwork>
                </div>

                <div class="pt-3">
                  <TextInput
                    type="text"
                    disabled
                    :value="projectLink"
                    class="w-full"
                  />
                  <PopoverButton
                    @click="copyLink"
                    class="secondary-btn w-full mt-2"
                  >
                    Copy link
                  </PopoverButton>
                </div>
              </PopoverPanel>
            </transition>
          </Popover>
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
import { ShareNetwork } from 'vue-social-sharing'

export default {
  layout: Layout
}
</script>

<script setup>
import { ShareIcon, PencilIcon } from '@heroicons/vue/outline'
import { Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'

import dayjs from '@/dayjs'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import SecondaryButton from '@/Components/Common/SecondaryButton.vue'
import ProjectModal from '@/Components/Projects/ProjectModal.vue'
import { useToast } from 'vue-toastification'
import TextInput from '@/Components/Form/TextInput.vue'

const props = defineProps({
  project: Object,
  applied: Boolean,
  saved: Boolean
})

const isOpen = ref(false)
const saved = ref(props.saved)
const project = props.project

const createdAtDiff = dayjs(project.created_at).fromNow()
const user = usePage().props.auth.user
const toast = useToast()

const isOwner = project.user.id === user.id
const applyDisabled = computed(() => props.applied || isOwner)

const projectLink = window.location.href

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

const copyLink = async () => {
  await navigator?.clipboard?.writeText(projectLink)
  toast('Copied to clipboard')
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

const projectShareTitle = `Check out project '${project.name}' on CollabFinder.`
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

:deep .social-icon-wrapper {
  @apply inline-flex items-center justify-center text-white p-1.5 rounded;
}
</style>
