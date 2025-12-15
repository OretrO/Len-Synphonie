@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Contact</h1>

            <p class="card-text">
                Pour toute question concernant le projet LenSymphony-Web, vous pouvez contacter
                l’équipe pédagogique ou les membres du groupe via les canaux habituels (ENT, GitLab, etc.).
            </p>

            <form method="post" action="#" class="contact-form">
                @csrf
                <div class="form-field">
                    <label class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-input" placeholder="votre.email@example.com" disabled>
                </div>

                <div class="form-field">
                    <label class="form-label">Message</label>
                    <textarea class="form-input form-textarea" rows="4" placeholder="Formulaire de démonstration (non fonctionnel)." disabled></textarea>
                </div>

                <p class="form-hint">
                    Ce formulaire est purement démonstratif dans le cadre du sprint 1.
                </p>
            </form>
        </div>
    </div>
@endsection
