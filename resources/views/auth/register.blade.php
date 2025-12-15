<x-layouts.aut title="Inscription">
    <x-auth.card>
        <x-slot name="header">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="auth-title text-2xl">Créer un compte</h1>
                    <p class="auth-subtitle mt-1">Rejoignez LenSymphony</p>
                </div>
                <a href="{{ route('login') }}" class="btn btn-outline text-sm">Se connecter</a>
            </div>
        </x-slot>

        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
            @csrf

            <!-- Avatar Upload -->
            <div class="avatar-upload">
                <div id="avatarPreview" class="avatar-preview flex items-center justify-center">
                    <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="avatar-overlay">
                    <svg class="avatar-overlay-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <input type="file" id="avatar" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/png,image/jpeg,image/jpg">
            </div>
            <p class="text-xs text-center text-slate-500 -mt-4">PNG/JPEG, max 2Mo, 512x512px</p>
            @error('avatar') <p class="form-error text-center">{{ $message }}</p> @enderror

            <!-- Nom d'utilisateur -->
            <div class="form-group">
                <label for="name" class="form-label">Nom d'utilisateur <span class="text-red-400">*</span></label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required autocomplete="username" placeholder="JohnDoe123">
                </div>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse e-mail <span class="text-red-400">*</span></label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autocomplete="email" placeholder="john.doe@example.com">
                </div>
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe <span class="text-red-400">*</span></label>
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
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe <span class="text-red-400">*</span></label>
                <div class="input-icon-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required autocomplete="new-password" placeholder="••••••••">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-full ripple">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Créer mon compte
            </button>

            <p class="text-xs text-center text-slate-500 mt-4">
                En créant un compte, vous acceptez les conditions d'utilisation de LenSymphony.
            </p>
        </form>
    </x-auth.card>

    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('avatarPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = '<img src="' + event.target.result + '" alt="Avatar" class="w-full h-full object-cover rounded-full">';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layouts.aut>
