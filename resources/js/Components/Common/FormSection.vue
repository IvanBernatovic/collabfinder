<template>
  <div class="bg-white dark:bg-gray-900 p-8 rounded-md card-shadow shadow-lg">
    <header>
      <h2 class="text-lg font-semibold pb-6 border-b border-gray-200 dark:border-gray-700">
        <slot name="title"></slot>
      </h2>
    </header>

    <main class="pt-6">
      <slot></slot>
    </main>
  </div>
</template>

<script setup></script>
