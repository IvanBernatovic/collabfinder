<template>
  <input type="text"
    class="bg-[#F8F9FA] dark:bg-gray-900 p-2 leading-[20px] border border-[#DEE2E6] dark:border-gray-500 rounded-[4px] box-border outline-hidden text-sm focus:bg-white focus:dark:bg-gray-800 focus:border-[#495057] focus:dark:border-gray-200 transition-all"
    :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
</template>

<script>
export default {
  props: {
    modelValue: [String, Number]
  }
}
</script>
