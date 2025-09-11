<script>
import styled from 'vue-styled-components'
import JetApplicationLogo from './../Jetstream/ApplicationLogo'
import JetApplicationMark from './../Jetstream/ApplicationMark'
import JetDropdown from './../Jetstream/Dropdown'
import JetDropdownLink from './../Jetstream/DropdownLink'
import JetNavLink from './../Jetstream/NavLink'
import JetResponsiveNavLink from './../Jetstream/ResponsiveNavLink'

const DesktopNavigation = styled.div``
const MobileNavigation = styled.div``
const Navigation = styled.nav``
const PageContent = styled.main``
const StyledHeader = styled.header``
const HeaderInnerWrapper = styled.div``

export default {
  metaInfo: {
    titleTemplate: '%s | CollabFinder'
  },
  components: {
    JetApplicationLogo,
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    DesktopNavigation,
    MobileNavigation,
    Navigation,
    PageContent,
    StyledHeader,
    HeaderInnerWrapper
  },

  data() {
    return {
      showingNavigationDropdown: false
    }
  },

  methods: {
    switchToTeam(team) {
      this.$inertia.put(
        '/current-team',
        {
          team_id: team.id
        },
        {
          preserveState: false
        }
      )
    },

    logout() {
      axios.post('/logout').then(response => {
        window.location = '/'
      })
    }
  },

  computed: {
    path() {
      return window.location.pathname
    }
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <navigation class="bg-white border-b border-gray-100">
      <!-- Primary Navigation Menu -->
      <desktop-navigation class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
              <a href="/projects">
                <jet-application-mark class="block h-9 w-auto" />
              </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <jet-nav-link href="/projects" :active="$page.url == '/projects'">
                Projects
              </jet-nav-link>

              <jet-nav-link href="/projects/create" :active="$page.url == '/projects/create'">
                New project
              </jet-nav-link>

              <jet-nav-link href="/my-projects" :active="$page.url == '/my-projects'">
                My projects
              </jet-nav-link>
            </div>
          </div>

          <!-- Settings Dropdown -->
          <div class="hidden sm:flex sm:items-center sm:ml-6">
            <div class="ml-3 relative">
              <jet-dropdown align="right" width="48">
                <template #trigger>
                  <button v-if="$page.props.jetstream.managesProfilePhotos" class="
                      flex
                      text-sm
                      border-2 border-transparent
                      rounded-full
                      focus:outline-hidden
                      focus:border-gray-300
                      transition
                      duration-150
                      ease-in-out
                    ">
                    <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url"
                      :alt="$page.props.user.name" />
                  </button>

                  <button v-else class="
                      flex
                      items-center
                      text-sm
                      font-medium
                      text-gray-500
                      hover:text-gray-700
                      hover:border-gray-300
                      focus:outline-hidden
                      focus:text-gray-700
                      focus:border-gray-300
                      transition
                      duration-150
                      ease-in-out
                    ">
                    <div>{{ $page.props.user.name }}</div>

                    <div class="ml-1">
                      <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                      </svg>
                    </div>
                  </button>
                </template>

                <template #content>
                  <!-- Account Management -->
                  <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Account
                  </div>

                  <jet-dropdown-link href="/user/profile">
                    Profile
                  </jet-dropdown-link>

                  <jet-dropdown-link href="/user/api-tokens" v-if="$page.props.jetstream.hasApiFeatures">
                    API Tokens
                  </jet-dropdown-link>

                  <div class="border-t border-gray-100"></div>

                  <!-- Team Management -->
                  <template v-if="$page.props.jetstream.hasTeamFeatures">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Manage Team
                    </div>

                    <!-- Team Settings -->
                    <jet-dropdown-link :href="'/teams/' + $page.props.user.current_team.id">
                      Team Settings
                    </jet-dropdown-link>

                    <jet-dropdown-link href="/teams/create" v-if="$page.props.jetstream.canCreateTeams">
                      Create New Team
                    </jet-dropdown-link>

                    <div class="border-t border-gray-100"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Switch Teams
                    </div>

                    <template v-for="team in $page.props.user.all_teams">
                      <form @submit.prevent="switchToTeam(team)">
                        <jet-dropdown-link as="button">
                          <div class="flex items-center">
                            <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400"
                              fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              stroke="currentColor" viewBox="0 0 24 24">
                              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>{{ team.name }}</div>
                          </div>
                        </jet-dropdown-link>
                      </form>
                    </template>

                    <div class="border-t border-gray-100"></div>
                  </template>

                  <!-- Authentication -->
                  <form @submit.prevent="logout">
                    <jet-dropdown-link as="button"> Logout </jet-dropdown-link>
                  </form>
                </template>
              </jet-dropdown>
            </div>
          </div>

          <!-- Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="
                inline-flex
                items-center
                justify-center
                p-2
                rounded-md
                text-gray-400
                hover:text-gray-500
                hover:bg-gray-100
                focus:outline-hidden
                focus:bg-gray-100
                focus:text-gray-500
                transition
                duration-150
                ease-in-out
              ">
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{
                  hidden: showingNavigationDropdown,
                  'inline-flex': !showingNavigationDropdown
                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{
                  hidden: !showingNavigationDropdown,
                  'inline-flex': showingNavigationDropdown
                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </desktop-navigation>

      <!-- Responsive Navigation Menu -->
      <mobile-navigation :class="{
        block: showingNavigationDropdown,
        hidden: !showingNavigationDropdown
      }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <jet-responsive-nav-link href="/projects" :active="$page.props.currentRouteName == 'projects'">
            Projects
          </jet-responsive-nav-link>

          <jet-responsive-nav-link href="/projects/create" :active="$page.props.currentRouteName == 'projects.create'">
            Create project
          </jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
          <div class="flex items-center px-4">
            <div class="shrink-0">
              <img v-if="$page.props.jetstream.managesProfilePhotos" class="h-10 w-10 rounded-full"
                :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
            </div>

            <div>
              <div class="font-medium text-base text-gray-800">
                {{ $page.props.user.name }}
              </div>
              <div class="font-medium text-sm text-gray-500">
                {{ $page.props.user.email }}
              </div>
            </div>
          </div>

          <div class="mt-3 space-y-1">
            <jet-responsive-nav-link href="/user/profile" :active="$page.props.currentRouteName == 'profile.show'">
              Profile
            </jet-responsive-nav-link>

            <jet-responsive-nav-link href="/user/api-tokens"
              :active="$page.props.currentRouteName == 'api-tokens.index'" v-if="$page.props.jetstream.hasApiFeatures">
              API Tokens
            </jet-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" @submit.prevent="logout">
              <jet-responsive-nav-link as="button">
                Logout
              </jet-responsive-nav-link>
            </form>

            <!-- Team Management -->
            <template v-if="$page.props.jetstream.hasTeamFeatures">
              <div class="border-t border-gray-200"></div>

              <div class="block px-4 py-2 text-xs text-gray-400">
                Manage Team
              </div>

              <!-- Team Settings -->
              <jet-responsive-nav-link :href="'/teams/' + $page.props.user.current_team.id"
                :active="$page.props.currentRouteName == 'teams.show'">
                Team Settings
              </jet-responsive-nav-link>

              <jet-responsive-nav-link href="/teams/create" :active="$page.props.currentRouteName == 'teams.create'">
                Create New Team
              </jet-responsive-nav-link>

              <div class="border-t border-gray-200"></div>

              <!-- Team Switcher -->
              <div class="block px-4 py-2 text-xs text-gray-400">
                Switch Teams
              </div>

              <template v-for="team in $page.props.user.all_teams">
                <form @submit.prevent="switchToTeam(team)" :key="team.id">
                  <jet-responsive-nav-link as="button">
                    <div class="flex items-center">
                      <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      <div>{{ team.name }}</div>
                    </div>
                  </jet-responsive-nav-link>
                </form>
              </template>
            </template>
          </div>
        </div>
      </mobile-navigation>
    </navigation>

    <!-- Page Heading -->
    <styled-header class="bg-white shadow-sm">
      <header-inner-wrapper class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </header-inner-wrapper>
    </styled-header>

    <!-- Page Content -->
    <page-content class="p-2">
      <slot></slot>
    </page-content>

  </div>
</template>
