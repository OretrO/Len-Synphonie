<x-layouts.aut title="Réinitialiser le mot de passe">
    <x-auth.card>
        <x-slot name="header">
            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(6, 214, 160, 0.2), rgba(59, 130, 246, 0.2));">
                    <svg class="w-8 h-8" style="color: #06d6a0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h1 class="auth-title text-2xl">Nouveau mot de passe</h1>
                <p class="auth-subtitle mt-2">Choisissez un mot de passe sécurisé</p>
            </div>
        </x-slot>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse e-mail</label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <input type="email" id="email" name="email" class="form-input" value="{{ $email ?? old('email') }}" required autofocus autocomplete="email" placeholder="john.doe@example.com">
                </div>
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Nouveau mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input type="password" id="password" name="password" class="form-input" required autocomplete="new-password" placeholder="••••••••">
                </div>
                <p class="form-hint">Min. 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre</p>
                @error('password') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Confirmation -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required autocomplete="new-password" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full ripple">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                Réinitialiser le mot de passe
            </button>
        </form>
    </x-auth.card>
</x-layouts.aut>
