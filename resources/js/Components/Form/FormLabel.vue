<template>
  <label class="font-medium leading-[20px] pb-2" :for="this.for">
    <slot></slot>
  </label>
</template>

<script>
export default {
  props: {
    for: String
  }
}
</script>
