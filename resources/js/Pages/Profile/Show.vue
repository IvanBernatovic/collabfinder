<template>
  <div class="sm:flex gap-4 py-6">
    <div class="w-2/5">
      <div class="hidden sm:block sm:fixed">
        <a
          v-for="link in sideLinks"
          :href="`#${link.id}`"
          class="side-link block"
          >{{ link.name }}</a
        >
      </div>
    </div>
    <div class="sm:w-3/5">
      <update-profile-information-form id="profile-info" />

      <update-password-form class="mt-10" id="update-password" />

      <update-notifications-settings
        class="mt-10"
        :tags="$page.props.tags"
        :roles="$page.props.roles"
        :notification-settings="$page.props.notificationSettings"
        id="notification-settings"
      />

      <logout-other-browser-sessions-form
        class="mt-10"
        :sessions="sessions"
        id="logout-other-sessions"
      />

      <delete-user-form
        id="delete-account"
        v-if="$page.props.jetstream.hasAccountDeletionFeatures"
        class="mt-10"
      />
    </div>
  </div>
</template>

<script setup>
import DeleteUserForm from './DeleteUserForm.vue'
import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm.vue'
import UpdatePasswordForm from './UpdatePasswordForm.vue'
import UpdateProfileInformationForm from './UpdateProfileInformationForm.vue'
import UpdateNotificationsSettings from '@/Components/Profile/UpdateNotificationsSettings.vue'

defineProps(['sessions'])

const sideLinks = [
  {
    name: 'Profile information',
    id: 'profile-info'
  },
  {
    name: 'Update password',
    id: 'update-password'
  },
  {
    name: 'Notification settings',
    id: 'notifications-settings'
  },
  {
    name: 'Logout other sessions',
    id: 'logout-other-sessions'
  },
  {
    name: 'Delete account',
    id: 'delete-account'
  }
]
</script>
