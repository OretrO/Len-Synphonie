<x-layouts.app>
    <x-slot:title>Réinitialiser le mot de passe</x-slot:title>

    <div class="page-container">
        <div class="card register-card">
            <h1 class="card-title">Nouveau mot de passe</h1>

            <p class="card-text">
                Choisissez un nouveau mot de passe sécurisé pour votre compte.
            </p>

            @if ($errors->any())
                <div class="alert alert-error">
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong>Erreur de validation</strong>
                        <ul class="alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="register-form">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-field">
                    <label for="email" class="form-label">
                        Adresse e-mail <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input @error('email') form-input-error @enderror"
                        value="{{ $email ?? old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="john.doe@example.com"
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="password" class="form-label">
                        Nouveau mot de passe <span class="required">*</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input @error('password') form-input-error @enderror"
                        required
                        autocomplete="new-password"
                    >
                    <p class="form-hint">
                        Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.
                    </p>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="password_confirmation" class="form-label">
                        Confirmer le mot de passe <span class="required">*</span>
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-input"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Réinitialiser le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

