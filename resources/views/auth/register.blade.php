<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-ltuc-dark mb-1">Join LTUC!</h2>
        <p class="text-ltuc-light text-sm">Create your account and start learning with AI</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-ltuc-dark font-medium mb-1 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-ltuc-light text-sm"></i>
                </div>
                <x-text-input id="name"
                    class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white text-ltuc-dark placeholder-ltuc-light focus:ring-2 focus:ring-ltuc-primary focus:border-transparent transition duration-300"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                    placeholder="Enter your full name" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-ltuc-dark font-medium mb-1 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-ltuc-light text-sm"></i>
                </div>
                <x-text-input id="email"
                    class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white text-ltuc-dark placeholder-ltuc-light focus:ring-2 focus:ring-ltuc-primary focus:border-transparent transition duration-300"
                    type="email" name="email" :value="old('email')" required autocomplete="username"
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
                    type="password" name="password" required autocomplete="new-password"
                    placeholder="Create a strong password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                class="text-ltuc-dark font-medium mb-1 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-ltuc-light text-sm"></i>
                </div>
                <x-text-input id="password_confirmation"
                    class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg bg-white text-ltuc-dark placeholder-ltuc-light focus:ring-2 focus:ring-ltuc-primary focus:border-transparent transition duration-300"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Confirm your password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Register Button -->
        <div class="pt-2">
            <x-primary-button
                class="w-full justify-center py-2.5 ltuc-primary text-white font-semibold rounded-lg hover:opacity-90 transform hover:scale-105 transition duration-300">
                <i class="fas fa-user-plus mr-2"></i>
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <!-- Terms and Privacy -->
        <div class="text-center">
            <p class="text-xs text-ltuc-light">
                By creating an account, you agree to our
                <a href="#" class="text-ltuc-primary hover:text-ltuc-accent transition duration-300">Terms of
                    Service</a>
                and
                <a href="#" class="text-ltuc-primary hover:text-ltuc-accent transition duration-300">Privacy
                    Policy</a>
            </p>
        </div>

        <!-- Divider -->
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-ltuc-light">Already have an account?</span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <a href="{{ route('login') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-50 text-ltuc-primary font-medium rounded-lg hover:bg-gray-100 transition duration-300 border border-gray-200 text-sm">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In Instead
            </a>
        </div>
    </form>
</x-guest-layout>
