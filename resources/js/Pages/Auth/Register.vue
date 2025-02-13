<template>
  <div class="flex">
    <AuthCarouselSection />

    <section
      class="flex-grow h-screen items-center flex justify-center"
      id="login"
    >
      <div class="w-[365px]">
        <form @submit.prevent="submit">
          <div class="mb-[20px]">
            <p class="text-sm text-gray-500">Start for free</p>
            <h1 class="font-bold text-3xl py-3">Sign up</h1>
            <p class="leading-5 text-gray-700">
              Already a member?
              <Link href="/login" class="mx-auto">Sign in</Link>
            </p>
          </div>

          <div class="py-6 flex flex-col gap-6">
            <form-group>
              <form-label for="name">Name</form-label>
              <text-input
                class="!p-[16px]"
                v-model="form.name"
                placeholder="Name"
                id="name"
                name="name"
                required
                minlength="2"
                autocomplete="off"
              />

              <InputError :message="form.errors.name" />
            </form-group>

            <form-group>
              <form-label for="email">Email</form-label>
              <text-input
                class="!p-[16px]"
                v-model="form.email"
                placeholder="Email"
                id="email"
                name="email"
                type="email"
                required
              />

              <InputError :message="form.errors.email" />
            </form-group>

            <form-group>
              <div class="flex justify-between items-center pb-2">
                <form-label class="pb-0" for="new-password"
                  >Password</form-label
                >
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
                autocomplete="new-password"
                id="new-password"
                name="new-password"
                required
                minlength="8"
              />

              <InputError :message="form.errors.password" />
            </form-group>

            <!-- <form-group>
              <form-label for="password_confirmation"
                >Password confirmation</form-label
              >
              <text-input
                class="!p-[16px]"
                v-model="form.password_confirmation"
                placeholder="Password confirmation"
                :type="password_type"
                id="password_confirmation"
                name="password_confirmation"
                required
                minlength="8"
              />

              <InputError :message="form.errors.password_confirmation" />
            </form-group> -->

            <FormGroup>
              <div class="flex items-center">
                <input
                  type="checkbox"
                  id="terms"
                  name="terms"
                  v-model="form.terms"
                  class="w-4 h-4 mr-2"
                  required
                />

                <label class="text-gray-700" for="terms"
                  >I agree with the
                  <a href="/terms" target="blank">terms of service</a></label
                >
              </div>

              <InputError :message="form.errors.terms_of_service" />
            </FormGroup>
          </div>

          <primary-button class="w-full mb-1" :disabled="form.processing"
            >Create your account</primary-button
          >
        </form>

        <p class="mt-2 text-gray-700 text-center">
          Already a member?
          <Link href="/login" class="mx-auto">Sign in</Link>
        </p>

        <social-login text="Or sign up with" />
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
import { Link } from '@inertiajs/vue3'
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
        name: '',
        email: '',
        password: '',
        // password_confirmation: '',
        terms: false
      }),
      password_type: 'password'
    }
  },
  methods: {
    submit() {
      this.form
        .transform(data => ({
          ...data,
          terms_of_service: this.form.terms
        }))
        .post('register', {
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
