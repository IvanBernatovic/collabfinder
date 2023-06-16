<template>
  <div class="bg-white p-8 rounded-md card-shadow shadow-lg">
    <header>
      <h2 class="text-lg font-semibold pb-6 border-b border-lightgray-200">
        <slot name="title"></slot>
      </h2>
    </header>

    <main class="pt-6">
      <slot></slot>
    </main>
  </div>
</template>

<script setup></script>
