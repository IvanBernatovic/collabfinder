<template>
  <Link
    class="p-2.5 font-medium box-border text-gray-700"
    :class="{ 'border-b-2 border-primary text-primary': active }"
  >
    <slot />
  </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  components: { Link },
  props: {
    active: {
      type: Boolean
    }
  }
}
</script>
