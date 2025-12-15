@extends('layouts.app')

@section('title', 'À propos')

@section('content')
    <x-layout.container>
        <x-section.title>
            À propos
        </x-section.title>

        <p class="mt-4 text-sm leading-relaxed text-gray-700 dark:text-gray-200">
            Cette application web LenSymphony-Web permet de gérer des partitions musicales.
            Elle est développée dans le cadre de la SAÉ S3.A.01 - Développement d’une application
            à l’IUT de Lens, Département Informatique.
        </p>

        <p class="mt-2 text-sm leading-relaxed text-gray-700 dark:text-gray-200">
            L’objectif de ce projet est de mettre en œuvre un système d’information complet en
            s’appuyant sur Laravel : modèles de données, migrations, modèles Eloquent, factories
            et seeders, ainsi que une interface utilisateur basée sur des composants Blade
            réutilisables.
        </p>
    </x-layout.container>
@endsection
