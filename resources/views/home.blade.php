<x-app-layout>
    <x-slot:header>
        Bienvenue sur LenSymphony
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">La musique collaborative</h2>
                <p class="mb-4">
                    LenSymphony est une application de gestion, orchestration et lecture de partitions musicales MusicXML.
                </p>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold mb-3">Partitions populaires</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h4 class="font-bold">Titre Partition 1</h4>
                            <p class="text-sm text-gray-600">Compositeur A</p>
                        </div>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h4 class="font-bold">Titre Partition 2</h4>
                            <p class="text-sm text-gray-600">Compositeur B</p>
                        </div>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h4 class="font-bold">Titre Partition 3</h4>
                            <p class="text-sm text-gray-600">Compositeur C</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
