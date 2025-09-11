<template>
  <UPopover :content="{ align: 'end' }">
    <UButton label="Date Posted" color="neutral" variant="outline" size="lg" icon="heroicons-solid:chevron-down"
      :trailing="true" />

    <template #content>
      <div class="overflow-hidden min-w-[200px] rounded-lg shadow-lg ring-1 ring-black/5 dark:ring-white/10">
        <div class="bg-white dark:bg-gray-900 p-4">
          <div class="flex flex-col gap-2">
            <div v-for="period in periods" :key="period.label" class="flex items-center">
              <input type="radio" name="period" :id="period.value" :value="period.value"
                :checked="period.value === modelValue" class="mr-1.5" @click="updatePeriod(period.value)" />
              <label class="cursor-pointer" :for="period.value">
                {{ period.label }}
              </label>
            </div>
          </div>

          <div class="mt-3 gap-2">
            <UButton @click="$emit('search')">Search</UButton>
          </div>
        </div>
      </div>
    </template>
  </UPopover>
</template>

<script>
import { ChevronDownIcon, XIcon } from '@heroicons/vue/solid'
import { computed, toRefs } from '@vue/reactivity'
import SecondaryButton from './SecondaryButton.vue'
import PrimaryButton from './PrimaryButton.vue'
export default {
  components: {
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
