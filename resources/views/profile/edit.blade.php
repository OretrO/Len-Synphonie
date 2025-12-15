<x-app-layout>
    <x-slot:header>
        Mon Profil
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-4 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations personnelles</h3>

                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Avatar</label>
                                <div class="mt-2 flex items-center space-x-4">
                                    <div class="shrink-0">
                                        @if($user->avatar)
                                            <img class="h-16 w-16 object-cover rounded-full border border-gray-200"
                                                 src="{{ asset('storage/' . $user->avatar) }}"
                                                 alt="Avatar actuel" />
                                        @else
                                            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="avatar" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100" />
                                </div>
                                <p class="mt-1 text-xs text-gray-500">PNG ou JPG (Max 2Mo, 512x512px).</p>
                                @error('avatar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nom d'utilisateur</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Adresse Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <hr class="border-gray-200 my-6">

                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Changer le mot de passe</h4>

                                <div class="grid gap-4">
                                    <div>
                                        <label for="current_password" class="block font-medium text-sm text-gray-700">Mot de passe actuel</label>
                                        <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="password" class="block font-medium text-sm text-gray-700">Nouveau mot de passe</label>
                                        <input id="password" name="password" type="password" autocomplete="new-password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmer le nouveau mot de passe</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-1 space-y-6">

                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Détails du compte</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Rôle :</span>
                                <span class="font-bold text-indigo-600 capitalize">{{ $user->role }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Inscrit le :</span>
                                <span>{{ $user->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow sm:rounded-lg p-6 opacity-75">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Mes contributions</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex justify-between border-b py-2">
                                <span>Commentaires postés</span>
                                <span class="font-bold">0</span> </li>
                            <li class="flex justify-between border-b py-2">
                                <span>Arrangements "Likés"</span>
                                <span class="font-bold">0</span> </li>
                            @if($user->role === 'arrangeur' || $user->role === 'admin')
                                <li class="flex justify-between border-b py-2">
                                    <span>Partitions créées</span>
                                    <span class="font-bold">0</span> </li>
                                <li class="flex justify-between pt-2">
                                    <span>Arrangements créés</span>
                                    <span class="font-bold">0</span> </li>
                            @endif
                        </ul>
                        <p class="mt-4 text-xs text-gray-400 italic text-center">
                            Historique complet disponible bientôt.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
