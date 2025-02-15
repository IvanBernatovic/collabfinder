<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label value="{{ __('Name') }}" />
                <x-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus
                    autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('Email') }}" />
                <x-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('Password') }}" />
                <x-input class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('Confirm Password') }}" />
                <x-input class="block mt-1 w-full" type="password" name="password_confirmation" required
                    autocomplete="new-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" name="agreement">
                    <span class="ml-2 text-sm text-gray-600">I agree with your <a href="/terms" class="text-indigo-700"
                            target="_blank">terms of service</a></span>
                </label>
            </div>

            <div class="mt-4">
                {!! app('captcha')->display() !!}

            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        @include('auth.social-login', ['action' => 'sign up'])
    </x-authentication-card>
</x-guest-layout>