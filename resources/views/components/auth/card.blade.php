@props(['title', 'subtitle' => null])

<div class="w-full max-w-md">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
        <!-- En-tête -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ $title }}
            </h1>
            @if($subtitle)
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {!! $subtitle !!}
                </p>
            @endif
        </div>

        <!-- Messages d'alerte -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Contenu -->
        {{ $slot }}
    </div>
</div>

