<template>
  <div class="flex px-3 sm:p-0">
    <AuthCarouselSection />

    <section
      class="flex-grow h-screen items-center flex justify-center"
      id="login"
    >
      <div class="w-[365px]">
        <form @submit.prevent="submit">
          <div class="mb-[40px]">
            <p class="text-sm text-gray-500">Start for free</p>
            <h1 class="font-bold text-3xl py-3">Sign in</h1>
            <p class="leading-5 text-gray-700">
              Welcome back. Sign in to your account.
            </p>
          </div>

          <form-group class="mb-6">
            <form-label for="email">Email</form-label>
            <text-input
              class="!p-[16px]"
              v-model="form.email"
              placeholder="Email"
              id="email"
              name="email"
              type="email"
              required
              aria-required="true"
            />

            <InputError :message="form.errors.email" />
          </form-group>

          <form-group>
            <div class="flex justify-between items-center pb-2">
              <form-label class="pb-0" for="password">Password</form-label>
              <button
                type="button"
                @click="togglePasswordType"
                class="text-sm text-primary"
              >
                {{ togglePasswordLabel }}
              </button>
            </div>
            <text-input
              class="!p-[16px]"
              v-model="form.password"
              placeholder="Password"
              :type="password_type"
              id="password"
              name="password"
              required
              aria-required="true"
              minlength="8"
              autocomplete="current-password"
            />
            <InputError :message="form.errors.password" />
          </form-group>

          <div class="flex justify-between mb-[40px] mt-4">
            <div class="flex items-center">
              <input
                type="checkbox"
                id="remember_me"
                name="remember_me"
                v-model="form.remember"
                class="w-4 h-4 mr-2"
              />

              <label class="text-gray-700" for="remember_me">Remember me</label>
            </div>
            <a href="/forgot" class="font-medium">Forgot your password?</a>
          </div>

          <primary-button class="w-full mb-1" :disabled="form.processing"
            >Sign in</primary-button
          >
        </form>

        <div class="text-center mt-2">
          New user? <Link href="/register" class="mx-auto">Sign up here</Link>
        </div>

        <social-login text="Or sign in with" />
      </div>
    </section>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import TextInput from 'Components/Form/TextInput.vue'
import FormLabel from 'Components/Form/FormLabel.vue'
import FormGroup from 'Components/Form/FormGroup.vue'
import PrimaryButton from 'Components/Common/PrimaryButton.vue'

import SocialLogin from 'Components/Common/SocialLogin.vue'
import AuthCarouselSection from 'Components/Common/AuthCarouselSection.vue'
import InputError from '@/Components/Form/InputError.vue'

export default {
  layout: null,
  components: {
    TextInput,
    FormLabel,
    FormGroup,
    PrimaryButton,
    SocialLogin,
    Link,
    AuthCarouselSection,
    InputError
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false
      }),
      password_type: 'password'
    }
  },
  methods: {
    submit() {
      this.form
        .transform(data => ({
          ...data,
          remember: this.form.remember ? 'on' : ''
        }))
        .post('login', {
          preserveState: true,
          onFinish: () => this.form.reset('password')
        })
    },
    togglePasswordType() {
      this.password_type =
        this.password_type === 'password' ? 'text' : 'password'
    }
  },
  computed: {
    togglePasswordLabel() {
      return this.password_type === 'password'
        ? 'Show password'
        : 'Hide password'
    }
  }
}
</script>

<style lang="postcss">
button#toggle-password {
  background: none;
  border: none;
  cursor: pointer;
  /* Media query isn't shown here. */
  font-size: var(--mobile-font-size);
  font-weight: 300;
  padding: 0;
  /* Display at the top right of the container */
  position: absolute;
  top: 0;
  right: 0;
}
</style>
