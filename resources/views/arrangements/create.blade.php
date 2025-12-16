<x-layouts.app>
    <x-slot:title>Create Arrangement</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <div class="page-header-inner">
                @if(!empty($partition))
                    <h1 class="page-header-title">Créer un arrangement pour : {{ $partition->title }}</h1>
                    <p class="home-section-sub">Remplissez les champs ci-dessous pour créer un arrangement (les fichiers audio sont générés en arrière-plan).</p>
                @else
                    <h1 class="page-header-title">Créer un arrangement</h1>
                    <p class="home-section-sub">Sélectionnez une partition et définissez les instruments pour chaque piste.</p>
                @endif
            </div>
        </div>

        <div class="card">
            @if(!empty($partition))
                <x-form-arrangement :partition="$partition" :instruments="$instruments" />
            @else
                <x-form-arrangement :partitions="$partitions" :instruments="$instruments" />
            @endif
        </div>
    </div>
</x-layouts.app>
