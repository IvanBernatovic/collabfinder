<template>
  <form @submit.prevent="$emit('projectSubmit', form)" autocomplete="off">
    <div class="p-6 flex flex-col gap-6 border-b border-gray-200 dark:border-gray-500">
      <FormGroup>
        <FormLabel for="name">Project name</FormLabel>
        <UInput class="w-full" v-model="form.name" placeholder="Project name" id="name" name="name" size="lg" />

        <InputError :message="form.errors.name" />
      </FormGroup>

      <FormGroup>
        <FormLabel for="description">Description</FormLabel>
        <Editor v-model="form.description" />
        <InputError :message="form.errors.description" />
      </FormGroup>

      <FormGroup>
        <FormLabel for="roles">Roles</FormLabel>
        <USelectMenu name="tags" v-model="form.roles" :items="roles.map(({ id, title }) => ({ id, title }))" multiple
          label-key="title" :closeOnSelect="false" placeholder="Select roles" size="lg" />
        <InputError :message="form.errors.roles" />
      </FormGroup>

      <FormGroup>
        <FormLabel for="tags">Tags</FormLabel>
        <USelectMenu name="tags" v-model="form.tags" :items="tags.map(({ id, name }) => ({ id, name }))" multiple
          label-key="name" :create-item="true" placeholder="Search by tags" size="lg"
          @create="(name) => form.tags.push({ name })" />
        <InputError :message="form.errors.tags" />
      </FormGroup>
    </div>

    <slot name="footer" :form="form"></slot>
  </form>
</template>

<script setup>
import { toRefs } from 'vue'
import { useForm } from '@inertiajs/vue3'

import FormGroup from '@/Components/Form/FormGroup.vue'
import FormLabel from '@/Components/Form/FormLabel.vue'
import Editor from '@/Components/Form/Editor.vue'
import InputError from '../Form/InputError.vue'

const props = defineProps(['project', 'roles', 'tags'])

const { project } = toRefs(props)

const form = useForm({
  name: project?.value?.name || '',
  description: project?.value?.description || '',
  roles: project?.value?.roles?.map(item => ({ id: item.id, title: item.title })) || [],
  tags: project?.value?.tags?.map(item => ({ id: item.id, name: item.name })) || []
})
</script>
