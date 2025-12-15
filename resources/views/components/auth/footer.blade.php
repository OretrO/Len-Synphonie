<footer class="py-8 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm border-t border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Logo et description -->
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">LenSymphony</span>
            </div>

            <!-- Liens -->
            <nav class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Home
                </a>
                <a href="{{ route('about') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    About
                </a>
                <a href="{{ route('contact') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Contact
                </a>
            </nav>

            <!-- Copyright -->
            <p class="text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} LenSymphony. All rights reserved.
            </p>
        </div>

        <!-- Ligne de crédit -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-500">
                Projet SAE S3.A.01 - IUT de Lens
            </p>
        </div>
    </div>
</footer>

