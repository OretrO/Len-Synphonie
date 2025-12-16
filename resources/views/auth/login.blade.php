<x-layouts.aut title="Log In">
    <x-auth.card>
        <x-slot name="header">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="auth-title text-2xl">Log In</h1>
                    <p class="auth-subtitle mt-1">Sign in to continue</p>
                </div>
                <a href="{{ route('register') }}" class="btn btn-outline text-sm">Sign Up</a>
            </div>
            <div class="auth-divider"><span>or</span></div>
        </x-slot>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="prenom.nom@example.com"
                        class="form-input"
                    />
                </div>
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="form-input"
                    />
                    <button type="button" id="togglePassword" class="password-toggle" aria-label="Show password">
                        <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.96 9.96 0 012.223-3.434M6.22 6.22L3 3m18 18l-3.22-3.22M9.88 9.88A3 3 0 0114.12 14.12" />
                        </svg>
                    </button>
                </div>
                @error('password') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="remember" class="checkbox-custom" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkbox-label">Remember me</span>
                </label>

                <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-full ripple">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Log in
            </button>

            <!-- Hint -->
            <p class="text-xs text-center text-slate-500 mt-4">
                By signing in, you agree to LenSymphony's terms of service.
            </p>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toggle = document.getElementById('togglePassword');
                const password = document.getElementById('password');
                const eyeOpen = document.getElementById('eyeOpen');
                const eyeClosed = document.getElementById('eyeClosed');

                if (toggle) {
                    toggle.addEventListener('click', function () {
                        if (password.type === 'password') {
                            password.type = 'text';
                            eyeOpen.classList.add('hidden');
                            eyeClosed.classList.remove('hidden');
                        } else {
                            password.type = 'password';
                            eyeOpen.classList.remove('hidden');
                            eyeClosed.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </x-auth.card>
</x-layouts.aut>
