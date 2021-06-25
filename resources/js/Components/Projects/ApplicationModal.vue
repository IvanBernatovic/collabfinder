<script>
import JetDialogModal from 'Jetstream/DialogModal'
import JetButton from 'Jetstream/Button'
import JetSecondaryButton from 'Jetstream/SecondaryButton'
import JetLabel from 'Jetstream/Label'

export default {
  props: ['show', 'message'],
  components: {
    JetDialogModal,
    JetLabel,
    JetButton,
    JetSecondaryButton
  }
}
</script>

<template>
  <jet-dialog-modal :show="show" @close="$emit('close')">
    <template #title>
      <h1 class="font-bold">Contact OP</h1>
    </template>

    <template #content>
      <div>
        <jet-label for="message">Message</jet-label>
        <textarea
          :value="message"
          @input="$emit('update:message', $event.target.value)"
          class="form-input w-full"
          rows="5"
          name="message"
          id="message"
          required
          placeholder="I would like to be part of this project because..."
        ></textarea>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click.native="closeContactModal">
        Cancel
      </jet-secondary-button>
      <jet-button
        type="submit"
        @click.native.prevent="$emit('apply-for-project')"
        :disabled="!message && message.length < 3"
        >Apply</jet-button
      >
    </template>
  </jet-dialog-modal>
</template>
