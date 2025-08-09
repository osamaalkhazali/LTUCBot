<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-ltuc-dark mb-1">Welcome Back!</h2>
        <p class="text-ltuc-light text-sm">Sign in to continue your learning journey</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-ltuc-dark font-medium mb-1 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-ltuc-light text-sm"></i>
                </div>
                <x-text-input id="email"
                    class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white text-ltuc-dark placeholder-ltuc-light focus:ring-2 focus:ring-ltuc-primary focus:border-transparent transition duration-300"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="Enter your email address" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-ltuc-dark font-medium mb-1 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-ltuc-light text-sm"></i>
                </div>
                <x-text-input id="password"
                    class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white text-ltuc-dark placeholder-ltuc-light focus:ring-2 focus:ring-ltuc-primary focus:border-transparent transition duration-300"
                    type="password" name="password" required autocomplete="current-password"
                    placeholder="Enter your password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 bg-white text-ltuc-primary shadow-sm focus:ring-ltuc-primary focus:ring-offset-0"
                    name="remember">
                <span class="ms-2 text-xs text-ltuc-light">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-ltuc-primary hover:text-ltuc-accent transition duration-300"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="pt-2">
            <x-primary-button
                class="w-full justify-center py-2.5 ltuc-primary text-white font-semibold rounded-lg hover:opacity-90 transform hover:scale-105 transition duration-300">
                <i class="fas fa-sign-in-alt mr-2"></i>
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <!-- Divider -->
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-ltuc-light">Don't have an account?</span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <a href="{{ route('register') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-50 text-ltuc-primary font-medium rounded-lg hover:bg-gray-100 transition duration-300 border border-gray-200 text-sm">
                <i class="fas fa-user-plus mr-2"></i>
                Create New Account
            </a>
        </div>
    </form>
</x-guest-layout>
