<template>
  <nav class="sm:hidden" @focusout="open = false" tabindex="0">
    <div class="nav__inner">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        stroke-width="2" @click="open = !open">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>

      <div class="flex items-center">
        <Logo width="24" height="24" />
        <Link class="text-md uppercase font-bold ml-2 text-black dark:text-white" href="/">CollabFinder</Link>
      </div>
    </div>

    <div class="absolute transition-all bg-white dark:bg-gray-800 px-3 w-full z-55 shadow-md pb-2"
      :class="{ '-translate-y-full': !open, 'translate-y-0': open }">
      <Link href="/projects"
        class="text-gray-900 dark:text-gray-100 group flex rounded-md items-center w-full px-2 py-2 text-sm" :class="{
          'text-primary font-medium': $page.url === '/projects'
        }">
      Home
      </Link>
      <Link href="/my-projects"
        class="text-gray-900 dark:text-gray-100 group flex rounded-md items-center w-full px-2 py-2 text-sm" :class="{
          'text-primary font-medium': $page.url.startsWith('/my-projects')
        }">
      My projects
      </Link>
      <Link href="/projects/create"
        class="text-gray-900 dark:text-gray-100 group flex rounded-md items-center w-full px-2 py-2 text-sm" :class="{
          'text-primary font-medium': $page.url === '/projects/create'
        }">
      Create new project
      </Link>
      <Link href="/user/profile"
        class="text-gray-900 dark:text-gray-100 group flex rounded-md items-center w-full px-2 py-2 text-sm" :class="{
          'text-primary font-medium': $page.url === '/user/profile'
        }">
      Settings
      </Link>
      <form @submit.prevent="logout">
        <button :class="[
          'group flex rounded-md items-center w-full px-2 py-2 text-sm text-gray-900 dark:text-gray-100'
        ]" type="submit">
          Logout
        </button>
      </form>
    </div>
  </nav>

  <nav class="py-4 hidden sm:block text-gray-900 dark:text-gray-100">
    <div class="max-w-(--breakpoint-lg) mx-auto grid grid-cols-3">
      <div class="flex items-center">
        <Logo width="41" height="40" />
        <Link class="text-lg uppercase font-bold ml-2 text-gray-900 dark:text-gray-100" href="/">CollabFinder</Link>
      </div>

      <div class="flex gap-4 justify-center items-center text-gray-900">
        <NavLink href="/projects" :active="$page.component === 'Projects/Index'">Projects</NavLink>
        <NavLink href="/my-projects" :active="$page.component === 'Projects/MyProjects'">My Projects</NavLink>
        <NavLink href="/projects/create" :active="$page.component === 'Projects/Create'">
          New project
        </NavLink>
      </div>

      <div class="flex gap-4 justify-end items-center">
        <UDropdownMenu :items="menuItems" :ui="{
          content: 'w-48'
        }">
          <img class="rounded-full w-10 h-10 object-cover cursor-pointer"
            :src="`https://www.gravatar.com/avatar/${hashedEmail}`" alt="Your avatar image" />

          <template #item-leading="{ item }">
            <UIcon :name="item.icon" class="text-green-500 size-5" />
          </template>
        </UDropdownMenu>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'
import md5 from 'md5'

import { Link, router } from '@inertiajs/vue3'
import Logo from 'Icons/Logo.vue'
import NavLink from '@/Components/Common/NavLink.vue'
import { useUser } from '@/helpers'

const user = useUser()

const hashedEmail = md5(user.email)

const open = ref()

const logout = () => {
  axios.post('/logout').then(response => {
    window.location = '/'
  })
}

const menuItems = ref([
  {
    label: 'Settings',
    icon: 'heroicons:cog-6-tooth-solid',
    target: '/user/profile',
    onSelect: () => router.get('/user/profile'),
  },
  {
    label: 'Logout',
    icon: 'heroicons:arrow-right-start-on-rectangle-20-solid',
    onSelect: logout
  }
])
</script>
