@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <x-layout.container>
        <x-section.title>
            Contact
        </x-section.title>

        <p class="mt-4 text-sm text-gray-700 dark:text-gray-200">
            Pour toute question concernant le projet LenSymphony-Web, vous pouvez contacter
            l’équipe pédagogique ou les membres du groupe via les canaux habituels
            (ENT, GitLab, etc.).
        </p>

        <form method="post" action="#" class="mt-6 max-w-md space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">
                    Adresse e-mail
                </label>
                <input
                    type="email"
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm
                           focus:border-indigo-500 focus:ring-indigo-500
                           dark:bg-neutral-900 dark:border-neutral-700 dark:text-gray-100"
                    placeholder="votre.email@example.com"
                    disabled
                >
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">
                    Message
                </label>
                <textarea
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm
                           focus:border-indigo-500 focus:ring-indigo-500
                           dark:bg-neutral-900 dark:border-neutral-700 dark:text-gray-100"
                    rows="4"
                    placeholder="Formulaire de démonstration (non fonctionnel)."
                    disabled
                ></textarea>
            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400">
                Ce formulaire est purement démonstratif dans le cadre du sprint 1.
            </p>
        </form>
    </x-layout.container>
@endsection
