@extends('layouts.app')

@section('title', 'À propos')

@section('content')
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">À propos</h1>

            <p class="card-text">
                LenSymphony-Web est une application web permettant de gérer des partitions musicales
                (import, organisation, consultation et partage), développée dans le cadre de la SAÉ S3.A.01
                - Développement d’une application à l’IUT de Lens.
            </p>

            <p class="card-text card-text-muted">
                Le projet met en œuvre un système d’information complet avec Laravel : modèles de données,
                migrations, modèles Eloquent, factories/seeders, ainsi qu’une interface basée sur des
                composants Blade réutilisables.
            </p>
        </div>
    </div>
@endsection
