<x-layouts.aut title="Connexion">
    <x-auth.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Connexion</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Connectez-vous pour continuer</p>
                        </div>
                        <a href="{{ route('register') }}" class="text-sm inline-flex items-center gap-2 rounded-md px-3 py-2 bg-white/10 text-blue-700 hover:bg-white/20 border border-white/5">Créer un compte</a>
                    </div>
                    <div class="border-t border-gray-100 dark:border-gray-700 mb-4"></div>
                </x-slot>

                <!-- Form amélioré -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adresse e-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="prenom.nom@example.com"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        />
                        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mot de passe</label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="block w-full px-4 pr-12 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            />

                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300" aria-label="Afficher le mot de passe">
                                <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.96 9.96 0 012.223-3.434M6.22 6.22L3 3m18 18l-3.22-3.22M9.88 9.88A3 3 0 0114.12 14.12" />
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2">Rester connecté</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Mot de passe oublié ?</a>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-x-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-5 py-3 transition-shadow shadow-md">Se connecter</button>
                    </div>

                    <!-- Small hint -->
                    <p class="text-xs text-center text-gray-500 mt-2">En vous connectant, vous acceptez les conditions d'utilisation de LenSymphony.</p>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const toggle = document.getElementById('togglePassword');
                        const password = document.getElementById('password');
                        const eyeOpen = document.getElementById('eyeOpen');
                        const eyeClosed = document.getElementById('eyeClosed');

                        if (toggle) {
                            toggle.addEventListener('click', function () {
                                if (password.type === 'password') {
                                    password.type = 'text';
                                    eyeOpen.classList.add('hidden');
                                    eyeClosed.classList.remove('hidden');
                                    toggle.setAttribute('aria-label', 'Masquer le mot de passe');
                                } else {
                                    password.type = 'password';
                                    eyeOpen.classList.remove('hidden');
                                    eyeClosed.classList.add('hidden');
                                    toggle.setAttribute('aria-label', 'Afficher le mot de passe');
                                }
                            });
                        }
                    });
                </script>
            </x-auth.card>
</x-layouts.aut>
