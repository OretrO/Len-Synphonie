<header class="py-6 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="inline-flex items-center text-2xl font-bold text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
                LenSymphony
            </a>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Home
                </a>
                <a href="{{ route('about') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    About
                </a>
                <a href="{{ route('contact') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Contact
                </a>
            </nav>

            <!-- Bouton Connexion/Inscription -->
            @guest
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-sm px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Sign Up
                    </a>
                </div>
            @endguest

            @auth
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</header>

