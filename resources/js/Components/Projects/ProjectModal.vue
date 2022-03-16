<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="$emit('close')">
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
                  @click="$emit('apply', form)"
                  :disabled="form.message.length < 3"
                  >Submit application</PrimaryButton
                >
                <SecondaryButton @click="$emit('close')"
                  >Cancel</SecondaryButton
                >
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { CloudUploadIcon } from '@heroicons/vue/outline'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogOverlay,
  DialogTitle
} from '@headlessui/vue'
import { useForm } from '@inertiajs/inertia-vue3'

import PrimaryButton from '@/Components/Common/PrimaryButton.vue'
import SecondaryButton from '@/Components/Common/SecondaryButton.vue'

const props = defineProps(['isOpen'])

const form = useForm({
  message: '',
  file: null
})
</script>
