@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Bienvenue sur LenSymphony</h1>

            <p class="card-text">
                Application web pour gérer, organiser et consulter des partitions musicales au format MusicXML,
                développée dans le cadre de la SAÉ S3.A.01 à l'IUT de Lens.
            </p>

            <p class="card-text card-text-muted">
                Utilise la barre de navigation en haut pour découvrir le projet ou nous contacter.
            </p>

            <div class="card-actions">
                <a href="{{ route('about') }}" class="btn btn-primary">About</a>
                <a href="{{ route('contact') }}" class="btn btn-outline">Contact</a>
            </div>
        </div>
    </div>
@endsection
