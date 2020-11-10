<script>
import styled from "vue-styled-components";

const PaginationInnerWrapper = styled.div``;

export default {
  props: {
    nextUrl: {
      type: String,
      default: "",
    },
    previousUrl: {
      type: String,
      default: "",
    },
  },
  components: {
    PaginationInnerWrapper,
  },
};
</script>

<template>
  <div>
    <inertia-link :disabled="!previousUrl" :href="previousUrl"
      >Previous</inertia-link
    >
    <inertia-link :disabled="!nextUrl" :href="nextUrl">Next</inertia-link>
  </div>
</template>