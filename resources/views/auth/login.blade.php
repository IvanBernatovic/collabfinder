<x-guest-layout>
  <x-authentication-card>
    <x-slot name="logo">
      <div class="flex flex-col items-center">
        <x-authentication-card-logo />

        <h1 class="mt-4 text-3xl font-bold">Log in to your account</h1>
        <p>Or <a href="/register" class="text-indigo-700 font-semibold">register a new account</a></p>
      </div>

    </x-slot>

    <x-validation-errors class="mb-4" />

    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
      {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div>
        <x-label value="{{ __('Email') }}" />
        <x-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
      </div>

      <div class="mt-4">
        <x-label value="{{ __('Password') }}" />
        <x-input class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
      </div>

      <div class="block mt-4">
        <label class="flex items-center">
          <input type="checkbox" class="form-checkbox" name="remember">
          <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
        @endif

        <x-button class="ml-4">
          {{ __('Login') }}
        </x-button>
      </div>
    </form>

    @include('auth.social-login')
  </x-authentication-card>
</x-guest-layout>