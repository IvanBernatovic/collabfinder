<template>
  <input
    class="border-gray-300 focus:border-indigo-300 focus:ring-3 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-xs"
    :value="value"
    @input="$emit('input', $event.target.value)"
    ref="input"
  />
</template>

<script>
export default {
  props: ['value'],

  methods: {
    focus() {
      this.$refs.input.focus()
    }
  }
}
</script>
