<template>
  <input
    type="text"
    class="
      bg-[#F8F9FA]
      p-[16px]
      leading-[20px]
      border border-[#DEE2E6]
      rounded-[4px]
      box-border
      outline-none
      text-sm
      focus:bg-white focus:border-[#495057]
      transition-all
    "
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>

<script>
export default {
  props: {
    modelValue: [String, Number]
  }
}
</script>
