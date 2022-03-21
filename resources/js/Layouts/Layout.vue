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
                  class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                      <Link
                        href="/user/profile"
                        :class="[
                          active
                            ? 'bg-gray-200 text-gray-900'
                            : 'text-gray-900',
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
    </header>

    <main class="bg-gray-100 flex-1 overflow-y-auto">
      <div class="max-w-screen-lg mx-auto">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { CogIcon, LogoutIcon } from '@heroicons/vue/solid'
import md5 from 'md5'

import Logo from 'Icons/Logo.vue'
import NavLink from '@/Components/Common/NavLink.vue'
import { useUser } from '@/helpers'

const user = useUser()

const hashedEmail = md5(user.email)

const logout = () => {
  axios.post('/logout').then(response => {
    window.location = '/'
  })
}
</script>
