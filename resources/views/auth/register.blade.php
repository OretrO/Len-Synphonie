<x-layouts.app title="Inscription - LenSymphony">
    @section('content')
    <div class="page-container">
        <div class="card register-card">
            <h1 class="card-title">Créer un compte</h1>

            <p class="card-text">
                Rejoignez LenSymphony pour créer, partager et découvrir des arrangements musicaux.
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

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="register-form">
                @csrf

                <!-- Nom d'utilisateur -->
                <div class="form-field">
                    <label for="name" class="form-label">
                        Nom d'utilisateur <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input @error('name') form-input-error @enderror"
                        value="{{ old('name') }}"
                        required
                        autocomplete="username"
                        placeholder="JohnDoe123"
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-field">
                    <label for="email" class="form-label">
                        Adresse e-mail <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input @error('email') form-input-error @enderror"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="john.doe@example.com"
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="form-field">
                    <label for="password" class="form-label">
                        Mot de passe <span class="required">*</span>
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

                <!-- Confirmation mot de passe -->
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

                <!-- Avatar -->
                <div class="form-field">
                    <label for="avatar" class="form-label">
                        Avatar (optionnel)
                    </label>
                    <div class="avatar-upload-container">
                        <div class="avatar-preview" id="avatarPreview">
                            <svg class="avatar-placeholder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="avatar-upload-info">
                            <label for="avatar" class="btn btn-outline avatar-upload-btn">
                                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Choisir une image
                            </label>
                            <input
                                type="file"
                                id="avatar"
                                name="avatar"
                                class="avatar-input"
                                accept="image/png,image/jpeg,image/jpg"
                            >
                            <p class="form-hint">
                                PNG ou JPEG, max 2 Mo, 512x512 pixels maximum
                            </p>
                        </div>
                    </div>
                    @error('avatar')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Créer mon compte
                    </button>
                </div>
            </form>

            <div class="register-footer">
                <p class="register-footer-text">
                    Vous avez déjà un compte ?
                    <a href="#" class="register-footer-link">Se connecter</a>
                </p>
            </div>
        </div>
    </div>

    <script>
    // Prévisualisation de l'avatar
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('avatarPreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.innerHTML = '<img src="' + event.target.result + '" alt="Avatar preview" class="avatar-preview-img">';
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '<svg class="avatar-placeholder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>';
        }
    });
    </script>
    @endsection
</x-layouts.app>
