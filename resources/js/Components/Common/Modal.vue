<template>
  <UModal :open="isOpen" v-on:update:open="(value) => $emit('update:isOpen', value)" :title="title">
    <template #content>
      <slot></slot>
    </template>
  </UModal>
  <!-- <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="$emit('close')">
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
          <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
            leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
            <DialogOverlay class="fixed inset-0 bg-black/30" />
          </TransitionChild>

          <span class="inline-block h-screen align-middle" aria-hidden="true">
            &#8203;
          </span>

          <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
              <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95">
                <div
                  class="inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-900 shadow-xl rounded-lg">
                  <div class="z-20 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 p-4">
                    <DialogTitle as="h3" class="text-l font-medium leading-6 text-gray-900 dark:text-gray-100 flex-1">
                      <slot name="title"></slot>
                    </DialogTitle>

                    <div class="p-1.5 cursor-pointer" @click="$emit('close')">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-3.h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </div>
                  </div>

                  <div class="px-4 border-b border-gray-200 dark:border-gray-700">
                    <slot></slot>
                  </div>
                </div>
              </TransitionChild>
            </div>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot> -->
</template>

<script setup>
defineProps(['isOpen', 'title'])
defineEmits(['close'])
</script>
