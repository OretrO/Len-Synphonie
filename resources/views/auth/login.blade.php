<x-layouts.aut title="Connexion">
    <x-auth.card
        title="Connexion"
        subtitle='Pas encore inscrit ? <a href="{{ route("register") }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-semibold">Inscrivez-vous ici</a>'
    >
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Adresse e-mail <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    placeholder="votre@email.com"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mot de passe <span class="text-red-500">*</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Mot de passe oublié ?
                    </a>
                </div>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Se souvenir de moi -->
            <div class="flex items-center mb-6">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                >
                <label for="remember" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Rester connecté
                </label>
            </div>

            <!-- Bouton de soumission -->
            <button
                type="submit"
                class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800"
            >
                Se connecter
            </button>
        </form>
    </x-auth.card>
</x-layouts.aut>

