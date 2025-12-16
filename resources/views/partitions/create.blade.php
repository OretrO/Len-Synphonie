<x-layouts.app>
    <x-slot:header>
        Ajouter une nouvelle partition
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('partitions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre de la partition *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required minlength="5" maxlength="50"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Ex: La 5ème Symphonie">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="composer" class="block text-sm font-medium text-gray-700">Compositeur / Auteur *</label>
                        <input type="text" name="composer" id="composer" value="{{ old('composer') }}" required minlength="5" maxlength="50"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Ex: Ludwig van Beethoven">
                        @error('composer') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700">Genre musical *</label>
                        <input type="text" name="genre" id="genre" value="{{ old('genre') }}" required maxlength="20"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Ex: Classique, Jazz, Rock">
                        @error('genre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description (Optionnelle)</label>
                        <textarea name="description" id="description" rows="4" maxlength="500"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                  placeholder="Contexte de l'œuvre...">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Maximum 500 caractères.</p>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label for="xml_file" class="block text-sm font-medium text-gray-700">Fichier MusicXML (.xml) *</label>
                            <input type="file" name="xml_file" id="xml_file" required accept=".xml,.musicxml"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-500 mt-1">Le fichier source pour la synthèse audio.</p>
                            @error('xml_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="pdf_file" class="block text-sm font-medium text-gray-700">Fichier PDF (Visuel) *</label>
                            <input type="file" name="pdf_file" id="pdf_file" required accept=".pdf"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-500 mt-1">Pour l'affichage de la partition.</p>
                            @error('pdf_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-3">
                        <a href="{{ route('partitions.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuler</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Enregistrer la partition
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layouts.app>
