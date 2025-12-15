@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'auth-card']) }}>
    <div class="auth-card-inner relative">
        <!-- En-tête (utilise un slot `header` si fourni pour personnaliser) -->
        @if(isset($header) && trim($header) !== '')
            {{ $header }}
        @else
            <div class="text-center mb-8">
                <h1 class="auth-title text-3xl">
                    {{ $title }}
                </h1>
                @if($subtitle)
                    <p class="auth-subtitle">
                        {!! $subtitle !!}
                    </p>
                @endif
            </div>
        @endif

        <!-- Messages d'alerte -->
        @if (session('status'))
            <div class="alert alert-success mb-6">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error mb-6">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <ul class="alert-list text-sm">
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
