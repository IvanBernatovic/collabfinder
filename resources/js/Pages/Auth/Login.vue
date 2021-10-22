<template>
  <div class="flex">
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

          <form-group>
            <form-label for="email">Email</form-label>
            <text-input
              v-model="form.email"
              placeholder="Email"
              id="email"
              name="email"
            />
          </form-group>

          <form-group>
            <form-label for="password">Password</form-label>
            <text-input
              v-model="form.password"
              placeholder="Password"
              type="password"
              id="password"
              name="password"
            />
          </form-group>

          <div class="flex justify-between mb-[40px]">
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

          <primary-button class="w-full mb-1">Sign in</primary-button>
        </form>

        <div class="text-center">
          <Link href="/register" class="mx-auto">New user? Sign up here</Link>
        </div>

        <social-login text="Or sign in with" />
      </div>
    </section>
  </div>
</template>

<script>
import TextInput from 'Components/Form/TextInput'
import FormLabel from 'Components/Form/FormLabel'
import FormGroup from 'Components/Form/FormGroup'
import PrimaryButton from 'Components/Common/PrimaryButton'

import SocialLogin from 'Components/Common/SocialLogin.vue'
import AuthCarouselSection from 'Components/Common/AuthCarouselSection.vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
  components: {
    TextInput,
    FormLabel,
    FormGroup,
    PrimaryButton,
    SocialLogin,
    Link,
    AuthCarouselSection
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false
      })
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
          onFinish: () => this.form.reset('password')
        })
    }
  }
}
</script>
