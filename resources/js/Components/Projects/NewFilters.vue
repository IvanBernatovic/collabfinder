<template>
  <div>
    <div class="bg-white dark:bg-gray-900 rounded-md p-4 shadow-lg mb-10">
      <div class="mb-4">
        <label class="font-semibold mb-1 block">Roles</label>
        <USelectMenu class="w-full" v-model="selectedRolesModel" @update:modelValue="handleRolesUpdate"
          :items="roles.map(({ id, title }) => ({ id, title }))" value-key="id" label-key="title" :multiple="true"
          placeholder="Search by roles" size="lg" />
      </div>

      <div class="mb-4">
        <label for="" class="font-semibold mb-1 block">Tags</label>
        <USelectMenu class="w-full" v-model="selectedTagsModel" @update:modelValue="handleTagsUpdate"
          :items="tags.map(({ id, name }) => ({ id, name }))" value-key="id" label-key="name" :searchable="true"
          :multiple="true" placeholder="Search by tags" size="lg" />
      </div>

      <PrimaryButton @click="$emit('apply-filters')">Search</PrimaryButton>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import PrimaryButton from 'Components/Common/PrimaryButton.vue'

const props = defineProps({
  roles: {
    type: Array,
    default: () => []
  },
  tags: {
    type: Array,
    default: () => []
  },
  selectedRoles: Array,
  selectedTags: Array,
  period: String
})

const emit = defineEmits(['update:selectedRoles', 'update:selectedTags', 'update:period', 'apply-filters'])

const periodModel = ref(null)
const selectedRolesModel = ref([])
const selectedTagsModel = ref([])

onMounted(() => {
  periodModel.value = props.period
  selectedRolesModel.value = props.selectedRoles || []
  selectedTagsModel.value = props.selectedTags || []
})

watch(() => props.selectedRoles, (newVal) => {
  selectedRolesModel.value = newVal || []
})

watch(() => props.selectedTags, (newVal) => {
  selectedTagsModel.value = newVal || []
})

watch(periodModel, (val) => {
  emit('update:period', val)
})

const handleRolesUpdate = (value) => {
  selectedRolesModel.value = value
  emit('update:selectedRoles', value)
}

const handleTagsUpdate = (value) => {
  selectedTagsModel.value = value
  emit('update:selectedTags', value)
}
</script>
