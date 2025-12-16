<x-layouts.aut title="Forgot password">
    <x-auth.card>
        <x-slot name="header">
            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(255, 45, 117, 0.2), rgba(181, 55, 242, 0.2));">
                    <svg class="w-8 h-8" style="color: #ff2d75;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h1 class="auth-title text-2xl">Forgot your password?</h1>
                <p class="auth-subtitle mt-2">Don't worry, we'll help you</p>
            </div>
        </x-slot>

        <p class="text-sm text-slate-400 text-center mb-6">
            Enter your email address and we'll send you a link to reset your password.
        </p>

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6" novalidate>
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="john.doe@example.com"
                    >
                </div>
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-full ripple">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Envoyer le lien
            </button>
        </form>

        <div class="auth-divider mt-6"><span>ou</span></div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="auth-link">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la connexion
            </a>
        </div>
    </x-auth.card>
</x-layouts.aut>
