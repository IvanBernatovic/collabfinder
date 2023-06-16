<template>
  <div class="flex flex-col h-screen">
    <header>
      <Navigation />
    </header>

    <main class="bg-gray-100 flex-1 overflow-y-auto">
      <div class="max-w-screen-lg mx-auto px-3 sm:p-0">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import Navigation from '@/Components/Common/Navigation.vue'
</script>
