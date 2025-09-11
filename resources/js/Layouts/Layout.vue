<template>
  <UApp>
    <div class="flex flex-col h-screen">
      <header>
        <Navigation />
      </header>

      <main class="bg-gray-100 dark:bg-gray-800 text-black dark:text-white flex-1 overflow-y-auto">
        <div class="max-w-(--breakpoint-lg) mx-auto px-3 sm:p-0">
          <slot />
        </div>
      </main>
    </div>
  </UApp>
</template>

<script setup>
import Navigation from 'Components/Common/Navigation.vue'
</script>
