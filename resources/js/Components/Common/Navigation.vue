<template>
  <nav class="sm:hidden" @focusout="open = false" tabindex="0">
    <div class="nav__inner">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
        @click="open = !open"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M4 6h16M4 12h16M4 18h16"
        />
      </svg>

      <div class="flex items-center">
        <logo width="24" height="24" />
        <Link class="text-md uppercase font-bold ml-2 text-black" href="/"
          >CollabFinder</Link
        >
      </div>
    </div>

    <div
      class="absolute transition-all bg-white px-3 w-full z-[55] shadow-md pb-2"
      :class="{ '-translate-y-full': !open, 'translate-y-0': open }"
    >
      <Link
        href="/projects"
        class="text-gray-900 group flex rounded-md items-center w-full px-2 py-2 text-sm"
        :class="{
          'text-primary font-medium': $page.url === '/projects'
        }"
      >
        Home
      </Link>
      <Link
        href="/my-projects"
        class="text-gray-900 group flex rounded-md items-center w-full px-2 py-2 text-sm"
        :class="{
          'text-primary font-medium': $page.url.startsWith('/my-projects')
        }"
      >
        My projects
      </Link>
      <Link
        href="/projects/create"
        class="text-gray-900 group flex rounded-md items-center w-full px-2 py-2 text-sm"
        :class="{
          'text-primary font-medium': $page.url === '/projects/create'
        }"
      >
        Create new project
      </Link>
      <Link
        href="/user/profile"
        class="text-gray-900 group flex rounded-md items-center w-full px-2 py-2 text-sm"
        :class="{
          'text-primary font-medium': $page.url === '/user/profile'
        }"
      >
        Settings
      </Link>
      <form @submit.prevent="logout">
        <button
          :class="[
            'group flex rounded-md items-center w-full px-2 py-2 text-sm text-gray-900'
          ]"
          type="submit"
        >
          Logout
        </button>
      </form>
    </div>
  </nav>
  <nav class="py-4 hidden sm:block">
    <div class="max-w-screen-lg mx-auto grid grid-cols-3">
      <div class="flex items-center">
        <logo width="41" height="40" />
        <Link class="text-lg uppercase font-bold ml-2 text-black" href="/"
          >CollabFinder</Link
        >
      </div>

      <div class="flex gap-4 justify-center items-center">
        <NavLink href="/projects" :active="$page.component === 'Projects/Index'"
          >Projects</NavLink
        >
        <NavLink
          href="/my-projects"
          :active="$page.component === 'Projects/MyProjects'"
          >My Projects</NavLink
        >
        <NavLink
          href="/projects/create"
          :active="$page.component === 'Projects/Create'"
          >
          New project
        </NavLink>
      </div>

      <div class="flex justify-end items-center">
        <Menu as="div" class="relative inline-block">
          <div>
            <MenuButton>
              <img
                class="rounded-full w-10 h-10 object-cover"
                :src="`https://www.gravatar.com/avatar/${hashedEmail}`"
                alt="Your avatar image"
              />
            </MenuButton>
          </div>

          <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
          >
            <MenuItems
              class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
            >
              <div class="px-1 py-1">
                <MenuItem v-slot="{ active }">
                  <Link
                    href="/user/profile"
                    :class="[
                      active ? 'bg-gray-200 text-gray-900' : 'text-gray-900',
                      'group flex rounded-md items-center w-full px-2 py-2 text-sm'
                    ]"
                  >
                    <CogIcon
                      :active="active"
                      class="w-5 h-5 mr-2 text-green-500"
                      aria-hidden="true"
                    />
                    Settings
                  </Link>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                  <form @submit.prevent="logout">
                    <button
                      :class="[
                        active ? 'bg-gray-200' : 'text-gray-900',
                        'group flex rounded-md items-center w-full px-2 py-2 text-sm'
                      ]"
                      type="submit"
                    >
                      <LogoutIcon
                        :active="active"
                        class="w-5 h-5 mr-2 text-green-500"
                        aria-hidden="true"
                      />
                      Logout
                    </button>
                  </form>
                </MenuItem>
              </div>
            </MenuItems>
          </transition>
        </Menu>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'
import md5 from 'md5'

import { Link } from '@inertiajs/vue3'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { CogIcon, LogoutIcon } from '@heroicons/vue/solid'
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
</script>

<style lang="postcss">
.nav__inner {
  @apply grid bg-white py-4 px-3 z-[500] relative;
  grid-template-columns: 1fr 1fr 1fr;
}
</style>
