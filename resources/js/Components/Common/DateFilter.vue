<template>
  <Popover v-slot="{ open }">
    <PopoverButton
      :class="open ? '' : 'text-opacity-90'"
      class="inline-flex items-center justify-center px-2 py-2 text-sm text-gray-700 border border-gray-200 font-medium rounded group hover:text-opacity-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 bg-white w-40"
    >
      <span>{{ selectedLabel || 'Date Posted' }}</span>
      <ChevronDownIcon
        :class="open ? '' : 'text-opacity-70'"
        class="w-5 h-5 ml-2 transition duration-150 ease-in-out group-hover:text-opacity-80"
        aria-hidden="true"
      />
    </PopoverButton>

    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="translate-y-1 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="translate-y-1 opacity-0"
    >
      <div class="relative">
        <PopoverPanel
          class="absolute right-0 z-10 mt-2 w-60 px-4 transform sm:px-0"
          v-slot="{ close }"
        >
          <div
            class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
          >
            <div class="bg-white">
              <div class="px-4">
                <div class="h-10">
                  <XIcon
                    @click="close"
                    class="w-7 h-7 p-1 cursor-pointer absolute top-2 right-2"
                  />
                </div>

                <div
                  v-for="period in periods"
                  :key="period.label"
                  class="flex items-center py-3"
                >
                  <input
                    type="radio"
                    name="period"
                    :id="period.value"
                    :value="period.value"
                    :checked="period.value === modelValue"
                    class="mr-4"
                    @click="updatePeriod(period.value)"
                  />
                  <label class="cursor-pointer" :for="period.value">
                    {{ period.label }}
                  </label>
                </div>
              </div>

              <div class="border-t border-gray-200 p-3 flex justify-end gap-2">
                <secondary-button @click="cancel(close)">
                  Cancel
                </secondary-button>
                <primary-button @click="$emit('search')">Search</primary-button>
              </div>
            </div>
          </div>
        </PopoverPanel>
      </div>
    </transition>
  </Popover>
</template>

<script>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { ChevronDownIcon, XIcon } from '@heroicons/vue/solid'
import { computed, toRefs } from '@vue/reactivity'
import SecondaryButton from './SecondaryButton.vue'
import PrimaryButton from './PrimaryButton.vue'
export default {
  components: {
    Popover,
    PopoverButton,
    PopoverPanel,
    ChevronDownIcon,
    SecondaryButton,
    PrimaryButton,
    XIcon
  },
  props: ['modelValue'],
  setup(props, { emit }) {
    const { modelValue } = toRefs(props)
    const updatePeriod = period => emit('update:modelValue', period)

    const cancel = close => {
      updatePeriod(null)
      close()
    }

    const periods = [
      {
        label: 'Past 24 hours',
        value: 'day'
      },
      {
        label: 'Past Week',
        value: 'week'
      },
      {
        label: 'Past Month',
        value: 'month'
      },
      {
        label: 'Any time',
        value: 'any'
      }
    ]

    const selectedLabel = computed(
      () => periods.find(per => per.value === modelValue.value)?.label
    )

    return {
      periods,
      selectedLabel,
      cancel,
      updatePeriod
    }
  }
}
</script>
