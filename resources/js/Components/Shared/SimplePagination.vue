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
  <div class="flex justify-center items-center">
    <div class="-mx-3">
      <inertia-link
        v-if="previousUrl"
        :href="previousUrl"
        class="pagination-button"
        >Previous</inertia-link
      >
      <button
        class="pagination-button"
        v-if="!previousUrl"
        disabled="!previousUrl"
      >
        Previous
      </button>
      <inertia-link v-if="nextUrl" class="pagination-button" :href="nextUrl"
        >Next</inertia-link
      >
      <button class="pagination-button" v-if="!nextUrl" disabled="!nextUrl">
        Next
      </button>
    </div>
  </div>
</template>

<style>
.pagination-button {
  @apply px-4 py-2 bg-white shadow rounded-md uppercase text-sm mx-3 font-semibold transition-colors duration-100;

  &:disabled {
    @apply opacity-50 cursor-not-allowed;
  }

  &:hover {
    @apply bg-gray-200;
  }
}
</style>