<template>
  <Multiselect />
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  components: {
    Multiselect
  }
}
</script>

<style lang="postcss">
.multiselect {
  @apply relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-[#F8F9FA] text-sm leading-snug outline-none;

  &.is-disabled {
    @apply cursor-default bg-gray-100;
  }

  &.is-open {
    @apply rounded-b-none;
  }

  &.is-open-top {
    @apply rounded-t-none;
  }

  &.is-active {
    /* @apply ring ring-green-500 ring-opacity-30; */
    @apply border-[#495057] bg-white;

    .multiselect-tags-search {
      @apply bg-white;
    }
  }
}

.multiselect-single-label {
  @apply flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5;
}

.multiselect-multiple-label {
  @apply flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5;
}

.multiselect-search {
  @apply w-full absolute inset-0 outline-none appearance-none box-border border-0 font-sans rounded pl-3.5;
}

.multiselect-tags {
  @apply flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2;
}

.multiselect-tag {
  @apply bg-gray-200 text-gray-700 text-sm py-0.5 pl-2 rounded mr-2 mb-1 flex items-center whitespace-nowrap;

  &.is-disabled {
    @apply pr-2 opacity-50;
  }
}

.multiselect-tag-remove {
  @apply flex items-center justify-center ml-1.5 p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10;
}

.multiselect-tag-remove-icon {
  @apply bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60;
}

.multiselect-tags-search-wrapper {
  @apply inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full;
}

.multiselect-tags-search {
  @apply absolute inset-0 border-0 outline-none appearance-none p-0 text-sm font-sans box-border w-full bg-[#F8F9FA];
}

.multiselect-tags-search-copy {
  @apply invisible whitespace-pre-wrap inline-block h-px;
}

.multiselect-placeholder {
  @apply flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400;
}

.multiselect-caret {
  @apply bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none;

  &.is-open {
    @apply rotate-180 pointer-events-auto;
  }
}

.multiselect-clear {
  @apply pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80;
}

.multiselect-clear-icon {
  @apply bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block;
}

.multiselect-spinner {
  @apply bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0;
}

.multiselect-dropdown {
  @apply max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b;

  &.is-top {
    @apply -translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t;
  }

  &.is-hidden {
    @apply hidden;
  }
}

.multiselect-options {
  @apply flex flex-col gap-1 p-2 m-0 list-none;

  &.is-top {
    @apply flex-col-reverse;
  }
}

.multiselect-group {
  @apply p-0 m-0;
}

.multiselect-group-label {
  @apply flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal;

  &.is-pointable {
    @apply cursor-pointer;
  }

  &.is-pointed {
    @apply bg-gray-300 text-gray-700;
  }

  &.is-selected {
    @apply bg-primary text-white;
  }

  &.is-disabled {
    @apply bg-gray-100 text-gray-300 cursor-not-allowed;
  }

  &.is-selected.is-pointed {
    @apply bg-primary text-white opacity-90;
  }

  &.is-selected.is-disabled {
    @apply text-green-100 bg-primary bg-opacity-50 cursor-not-allowed;
  }
}

.multiselect-group-options {
  @apply p-0 m-0;
}

.multiselect-option {
  @apply flex items-center justify-start box-border text-left cursor-pointer text-sm leading-snug py-2 px-3 rounded-md;

  &.is-pointed {
    @apply text-gray-800 bg-gray-100;
  }

  &.is-selected {
    @apply text-white bg-primary;
  }

  &.is-disabled {
    @apply text-gray-300 cursor-not-allowed;
  }

  &.is-selected.is-pointed {
    @apply text-white bg-primary opacity-90;
  }

  &.is-selected.is-disabled {
    @apply text-green-100 bg-primary bg-opacity-50 cursor-not-allowed;
  }
}

.multiselect-no-options {
  @apply py-2 px-3 text-gray-600 bg-white;
}

.multiselect-no-results {
  @apply py-2 px-3 text-gray-600 bg-white;
}

.multiselect-fake-input {
  @apply bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent;
}

.multiselect-spacer {
  @apply h-9 py-px box-content;
}
</style>
