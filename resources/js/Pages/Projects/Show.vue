<template>
  <div class="py-4 lg:w-2/3 mx-auto">
    <div class="p-6 bg-white rounded-lg">
      <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold">{{ project.name }}</h1>
        <button
          class="text-black p-2 rounded-lg ml-2 box-border border border-gray-500 hover:cursor-pointer"
        >
          <ShareIcon class="w-4 h-4 text-[#5C5F62]" />
        </button>
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
          :disabled="applied"
          >{{ applied ? 'Applied' : 'Apply now' }}</PrimaryButton
        >
        <SecondaryButton class="flex-1" @click="toggleSave">{{
          saved ? 'Unsave' : 'Save'
        }}</SecondaryButton>
      </div>

      <div class="mt-8">
        <h2 class="font-semibold text-lg">Description</h2>

        <article class="text-gray-800">{{ project.description }}</article>
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

  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal">
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <DialogOverlay class="fixed inset-0 bg-black opacity-30" />
          </TransitionChild>

          <span class="inline-block h-screen align-middle" aria-hidden="true">
            &#8203;
          </span>

          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <div
              class="inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg"
            >
              <div class="flex justify-between items-center border-b p-4">
                <DialogTitle
                  as="h3"
                  class="text-l font-medium leading-6 text-gray-900 flex-1"
                >
                  Apply
                </DialogTitle>

                <div class="p-1.5 cursor-pointer" @click="closeModal">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-3.h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </div>
              </div>

              <div class="px-4 border-b">
                <div>
                  <div class="py-4 box-border border-b">
                    <h2 class="font-semibold mb-4">Introduction message</h2>
                    <textarea
                      class="p-2 w-full border border-gray-200 rounded outline-green-300"
                      placeholder="Write why would you like to be part of this project..."
                      rows="5"
                      v-model="form.message"
                    ></textarea>
                  </div>
                  <div class="py-4">
                    <h2 class="font-semibold mb-4">Resume (optional)</h2>
                    <p class="mb-3 text-gray-700">
                      Upload your CV or portfolio if you think it matters for
                      this project.
                    </p>
                    <div class="flex gap-2 items-center">
                      <label
                        class="secondary-btn cursor-pointer transition-colors hover:bg-gray-50 !inline-flex gap-1"
                        for="file"
                      >
                        <CloudUploadIcon class="w-4 h-4 text-[#5C5F62]" /><span
                          class="whitespace-nowrap"
                          >Upload CV</span
                        >
                      </label>
                      <p
                        class="truncate"
                        v-if="form.file"
                        :title="form.file?.name"
                      >
                        {{ form.file?.name }}
                      </p>
                    </div>
                    <input
                      id="file"
                      class="hidden"
                      type="file"
                      name="file"
                      @input="form.file = $event.target.files[0]"
                      accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf"
                    />
                    <p class="uppercase font-light text-xs mt-2">
                      doc, docx, pdf
                    </p>
                  </div>
                </div>
              </div>

              <div class="px-4 py-6 flex gap-2">
                <PrimaryButton
                  @click="apply"
                  :disabled="form.message.length < 3"
                  >Submit application</PrimaryButton
                >
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'

export default {
  layout: Layout
}
</script>

<script setup>
import { ShareIcon, CloudUploadIcon } from '@heroicons/vue/outline'
import { ref } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogOverlay,
  DialogTitle
} from '@headlessui/vue'
import { useForm } from '@inertiajs/inertia-vue3'
import dayjs from '@/dayjs'
import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import SecondaryButton from '@/Components/Common/SecondaryButton.vue'

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
const form = useForm({
  message: '',
  file: null
})

const createdAtDiff = dayjs(project.created_at).fromNow()

const closeModal = () => {
  isOpen.value = false
}

const openModal = () => {
  isOpen.value = true
}

const apply = () => {
  form.post(`/projects/${project.id}/apply`)

  closeModal()
}

const toggleSave = async () => {
  await axios.post(`/projects/${project.id}/save`)

  saved.value = !saved.value
}
</script>
