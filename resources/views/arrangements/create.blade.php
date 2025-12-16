<x-layouts.app>
    <x-slot:title>Create Arrangement</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <div class="page-header-inner">
                <h1 class="page-header-title">Créer un arrangement pour : {{ $partition->title }}</h1>
                <p class="home-section-sub">Remplissez les champs ci-dessous pour créer un arrangement (les fichiers audio sont générés en arrière-plan).</p>
            </div>
        </div>

        <div class="card">
            <x-form-arrangement :partition="$partition" :instruments="$instruments" />
        </div>
    </div>
</x-layouts.app>

