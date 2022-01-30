<template>
  <div class="flex flex-col h-screen">
    <header>
      <nav class="py-4">
        <div class="max-w-screen-lg mx-auto grid grid-cols-3">
          <div class="flex items-center">
            <logo width="41" height="40" />
            <Link class="text-lg uppercase font-bold ml-2 text-black" href="/"
              >CollabFinder</Link
            >
          </div>

          <div class="flex gap-4 justify-center items-center">
            <NavLink
              href="/projects"
              :active="$page.component === 'Projects/Index'"
              >Projects</NavLink
            >
            <NavLink
              href="/my-projects"
              :active="$page.component === 'Projects/MyProjects'"
              >My Projects</NavLink
            >
          </div>

          <div class="flex justify-end items-center">Image</div>
        </div>
      </nav>
    </header>

    <main class="bg-gray-100 flex-1 overflow-y-auto">
      <div class="max-w-screen-lg mx-auto">
        <slot />
      </div>
    </main>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

import Logo from 'Icons/Logo.vue'
import NavLink from '@/Components/Common/NavLink.vue'

export default {
  components: { Logo, NavLink, Link }
}
</script>
