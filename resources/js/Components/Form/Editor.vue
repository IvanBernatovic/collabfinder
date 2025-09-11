<template>
  <div>
    <div class="flex gap-x-1">
      <button type="button" class="editor-btn" @click="editor.chain().focus().toggleBold().run()"
        :class="{ [classes.active]: editor?.isActive('bold') }">
        <svg width="8" height="12" viewBox="0 0 8 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M1.33333 5.33317H4.33333C4.77536 5.33317 5.19928 5.15758 5.51184 4.84502C5.82441 4.53245 6 4.10853 6 3.6665C6 3.22448 5.82441 2.80055 5.51184 2.48799C5.19928 2.17543 4.77536 1.99984 4.33333 1.99984H1.33333V5.33317ZM8 8.33317C8 8.72714 7.9224 9.11724 7.77164 9.48122C7.62087 9.8452 7.3999 10.1759 7.12132 10.4545C6.84274 10.7331 6.51203 10.954 6.14805 11.1048C5.78407 11.2556 5.39397 11.3332 5 11.3332H0V0.666504H4.33333C4.92064 0.666529 5.49502 0.838939 5.98525 1.16236C6.47548 1.48577 6.86 1.94597 7.09113 2.48588C7.32226 3.0258 7.38983 3.62168 7.28546 4.19963C7.18109 4.77759 6.90937 5.3122 6.504 5.73717C6.9591 6.0007 7.33689 6.37928 7.59947 6.83493C7.86205 7.29058 8.00018 7.80728 8 8.33317ZM1.33333 6.6665V9.99984H5C5.44203 9.99984 5.86595 9.82424 6.17851 9.51168C6.49107 9.19912 6.66667 8.7752 6.66667 8.33317C6.66667 7.89114 6.49107 7.46722 6.17851 7.15466C5.86595 6.8421 5.44203 6.6665 5 6.6665H1.33333Z" />
        </svg>
      </button>

      <button type="button" class="editor-btn" @click="editor.chain().focus().toggleItalic().run()"
        :class="{ [classes.active]: editor?.isActive('italic') }">
        <svg width="8" height="12" viewBox="0 0 8 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M5.99999 11.3332H0.666656V9.99984H2.61799L4.02866 1.99984H1.99999V0.666504H7.33332V1.99984H5.38199L3.97132 9.99984H5.99999V11.3332Z" />
        </svg>
      </button>

      <button type="button" class="editor-btn ml-4" @click="editor.chain().focus().toggleBulletList().run()"
        :class="{ [classes.active]: editor?.isActive('bulletList') }">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M3.33333 0.666829H12V2.00016H3.33333V0.666829ZM0 0.333496H2V2.3335H0V0.333496ZM0 5.00016H2V7.00016H0V5.00016ZM0 9.66683H2V11.6668H0V9.66683ZM3.33333 5.3335H12V6.66683H3.33333V5.3335ZM3.33333 10.0002H12V11.3335H3.33333V10.0002Z" />
        </svg>
      </button>

      <button type="button" class="editor-btn" @click="editor.chain().focus().toggleOrderedList().run()"
        :class="{ [classes.active]: editor?.isActive('orderedList') }">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M3.33333 0.666667H12V2H3.33333V0.666667ZM1.33333 0V2H2V2.66667H0V2H0.666667V0.666667H0V0H1.33333ZM0 7.33333V5.66667H1.33333V5.33333H0V4.66667H2V6.33333H0.666667V6.66667H2V7.33333H0ZM1.33333 11H0V10.3333H1.33333V10H0V9.33333H2V12H0V11.3333H1.33333V11ZM3.33333 5.33333H12V6.66667H3.33333V5.33333ZM3.33333 10H12V11.3333H3.33333V10Z" />
        </svg>
      </button>
    </div>

    <EditorContent :editor="editor" v-model="modelValue" class="mt-2"
      :class="{ 'empty-editor': modelValue?.length === 0 }" />
  </div>
</template>

<script setup>
import { EditorContent, useEditor } from '@tiptap/vue-3'
import { Placeholder } from '@tiptap/extension-placeholder'
import StarterKit from '@tiptap/starter-kit'
import { toRefs, computed } from 'vue'

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])

const classes = {
  active: 'bg-gray-200'
}

const { modelValue } = toRefs(props)

const editor = useEditor({
  content: modelValue.value,
  extensions: [
    StarterKit.configure({
      bold: true,
      paragraph: true,
      italic: true
    }),
    Placeholder.configure({
      emptyEditorClass: 'empty-editor',
      placeholder: 'Write about your project...'
    })
  ],
  onUpdate({ editor: ed }) {
    if (ed.getHTML() === '<p></p>') {
      emit('update:modelValue', '')
      return
    }

    emit('update:modelValue', ed.getHTML())
  },
  editorProps: {
    attributes: {
      class:
        'p-2 border border-gray-200 dark:border-gray-700 rounded-sm min-h-[120px] bg-[#F8F9FA] dark:bg-gray-900 rounded-[4px] focus:bg-white focus:dark:bg-gray-800 focus:border-[#495057] focus:dark:border-gray-300 outline-hidden transition-all'
    }
  }
})

const editorHtml = computed(() => editor?.getHTML?.())
</script>

<style lang="postcss">
@reference "../../../css/app.css"

.editor-btn {
  @apply flex size-7 justify-center items-center rounded hover:cursor-pointer;
}

.ProseMirror {
  ul {
    @apply list-disc ml-4;
  }

  ol {
    @apply list-decimal ml-4;
  }
}
</style>
