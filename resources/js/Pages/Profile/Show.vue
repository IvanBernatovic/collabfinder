<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <update-profile-information-form :user="$page.props.user" />

        <jet-section-border />

        <update-password-form class="mt-10 sm:mt-0" />

        <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
          <jet-section-border />

          <two-factor-authentication-form class="mt-10 sm:mt-0" />
        </div>

        <jet-section-border />

        <update-notifications-settings
          :tags="$page.props.tags"
          :roles="$page.props.roles"
          :notification-settings="$page.props.notificationSettings"
        />
        <jet-section-border />

        <logout-other-browser-sessions-form
          :sessions="sessions"
          class="mt-10 sm:mt-0"
        />

        <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
          <jet-section-border />

          <delete-user-form class="mt-10 sm:mt-0" />
        </template>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout'
import DeleteUserForm from './DeleteUserForm'
import JetSectionBorder from './../../Jetstream/SectionBorder'
import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
import UpdatePasswordForm from './UpdatePasswordForm'
import UpdateProfileInformationForm from './UpdateProfileInformationForm.vue'
import UpdateNotificationsSettings from 'Components/Profile/UpdateNotificationsSettings.vue'

export default {
  metaInfo: {
    title: 'Profile'
  },
  props: ['sessions'],
  components: {
    AppLayout,
    DeleteUserForm,
    JetSectionBorder,
    LogoutOtherBrowserSessionsForm,
    TwoFactorAuthenticationForm,
    UpdatePasswordForm,
    UpdateProfileInformationForm,
    UpdateNotificationsSettings
  }
}
</script>

UpdateNotificationsSettings
