<nav class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                        LenSymphony
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium text-gray-900">
                        Accueil
                    </a>
                    <a href="{{ route('partitions.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Partitions
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Contact
                    </a>
                </div>
            </div>

            <div class="flex items-center">
                @auth
                    <div class="ml-3 relative flex items-center space-x-4">
                        <span class="text-gray-700 text-sm">Bonjour, {{ Auth::user()->name }}</span>

                        <a href="{{ route('profile.show') }}" class="text-sm text-gray-500 hover:text-gray-900">
                            Mon Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Connexion</a>
                        <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-indigo-600 hover:text-indigo-500">Inscription</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
