
<x-layouts.app>
    <x-slot:title>Vérifiez votre email</x-slot:title>

    <div class="page-container">
        <div class="card register-card">
            <h1 class="card-title">Vérifiez votre adresse email</h1>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success">
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong>Email envoyé !</strong>
                        <p>Un nouveau lien de vérification a été envoyé à votre adresse email.</p>
                    </div>
                </div>
            @endif

            <div class="verification-message">
                <svg class="verification-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>

                <p class="card-text">
                    Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ?
                </p>

                <p class="card-text card-text-muted">
                    Si vous n'avez pas reçu l'email, nous serons ravis de vous en envoyer un autre.
                </p>
            </div>

            <form method="POST" action="{{ route('verification.send') }}" class="verification-form">
                @csrf
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Renvoyer l'email de vérification
                    </button>
                </div>
            </form>

            <div class="register-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="register-footer-link" style="background: none; border: none; cursor: pointer;">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
    .verification-message {
        text-align: center;
        padding: 2rem 0;
    }

    .verification-icon {
        width: 4rem;
        height: 4rem;
        color: #a5b4fc;
        margin: 0 auto 1.5rem;
        filter: drop-shadow(0 0 12px rgba(165, 180, 252, 0.5));
    }

    .verification-form {
        margin-top: 2rem;
    }
    </style>
</x-layouts.app>

