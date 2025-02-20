<template>
  <form @submit.prevent="$emit('projectSubmit', form)" autocomplete="off">
    <div class="p-6 flex flex-col gap-6 border-b border-gray-200">
      <FormGroup>
        <FormLabel for="name">Project name</FormLabel>
        <TextInput
          class="w-full"
          v-model="form.name"
          placeholder="Project name"
          id="name"
          name="name"
        />

        <InputError :message="form.errors.name" />
      </FormGroup>

      <FormGroup>
        <FormLabel for="description">Description</FormLabel>
        <Editor v-model="form.description" />
        <InputError :message="form.errors.description" />
      </FormGroup>

      <FormGroup>
        <FormLabel for="roles">Roles</FormLabel>
        <Multiselect
          v-model="form.roles"
          :options="roles"
          valueProp="id"
          trackBy="title"
          label="title"
          mode="tags"
          :searchable="true"
          :hideSelected="false"
          :closeOnSelect="false"
          placeholder="Select roles"
          :caret="false"
          :object="true"
        />
        <InputError :message="form.errors.roles" />
      </FormGroup>

      <FormGroup>
        <FormLabel for="tags">Tags</FormLabel>
        <Multiselect
          v-model="form.tags"
          :options="tags"
          mode="tags"
          valueProp="id"
          trackBy="name"
          label="name"
          :searchable="true"
          :createTag="true"
          placeholder="Search by tags"
          :caret="false"
          :closeOnSelect="false"
          :hideSelected="false"
          :object="true"
        />
        <InputError :message="form.errors.tags" />
      </FormGroup>
    </div>

    <slot name="footer" :form="form"></slot>
  </form>
</template>

<script setup>
import { toRefs } from 'vue'
import { useForm } from '@inertiajs/vue3'

import TextInput from '@/Components/Form/TextInput.vue'
import FormGroup from '@/Components/Form/FormGroup.vue'
import FormLabel from '@/Components/Form/FormLabel.vue'
import Editor from '@/Components/Form/Editor.vue'
import Multiselect from '@/Components/Form/Multiselect.vue'
import InputError from '../Form/InputError.vue'

const props = defineProps(['project', 'roles', 'tags'])

const { project } = toRefs(props)

const form = useForm({
  name: project?.value?.name || '',
  description: project?.value?.description || '',
  roles: project?.value?.roles || [],
  tags: project?.value?.tags || []
})
</script>
