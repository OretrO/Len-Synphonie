<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LenSymphony' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell {{ request()->routeIs('home') ? 'studio-mode' : '' }}">

{{-- Sidebar navigation --}}
<x-sidebar />

{{-- Profil utilisateur en haut à droite --}}
@auth
    <div class="user-profile-fixed">
        <span class="badge
            {{ auth()->user()->role === 'admin' ? 'badge-admin' : '' }}
            {{ auth()->user()->role === 'arranger' ? 'badge-arranger' : '' }}
            {{ auth()->user()->role === 'user' ? 'badge-user' : '' }}">
            {{ ucfirst(auth()->user()->role) }}
        </span>

        <div class="relative user-dropdown-container">
            <div class="navbar-user">
                @php
                    $avatar = auth()->user()->avatar;
                    $avatarPath = $avatar && $avatar !== 'avatars/default.svg' ? asset('storage/' . $avatar) : null;
                @endphp

                <div class="navbar-avatar flex items-center justify-center overflow-hidden">
                    @if($avatarPath)
                        <img src="{{ $avatarPath }}" alt="" class="w-full h-full object-cover" aria-hidden="true" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    <svg class="w-5 h-5 {{ $avatarPath ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <span class="navbar-username hidden md:inline">{{ auth()->user()->name }}</span>
                <svg class="navbar-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div class="dropdown-menu">
                <div class="px-4 py-3 border-b" style="border-color: var(--color-border);">
                    <p class="text-sm font-semibold" style="color: var(--color-text);">{{ auth()->user()->name }}</p>
                    <p class="text-xs mt-1" style="color: var(--color-text-secondary);">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('profile.show') }}" class="dropdown-item">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    My Profile
                </a>

                @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                    <a href="{{ route('partitions.index') }}" class="dropdown-item">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                        My Scores
                    </a>
                @endif

                <div class="border-t mt-1 pt-1" style="border-color: var(--color-border);">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-left w-full" style="color: var(--color-error);">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth

<main>
    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="page-container" style="padding-top: 32px;">
            <div class="alert alert-success">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <strong>Success!</strong>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="page-container" style="padding-top: 32px;">
            <div class="alert alert-error">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <strong>Error!</strong>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('status'))
        <div class="page-container" style="padding-top: 32px;">
            <div class="alert bg-blue-500/10 border-blue-500/30 text-blue-300">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm">{{ session('status') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="page-container" style="padding-top: 32px;">
            <div class="alert alert-error">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <strong>Validation errors</strong>
                    <ul class="alert-list mt-2 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{ $slot }}
</main>

<x-footer />

{{-- Navigation mobile (visible seulement sur mobile) --}}
<nav class="mobile-bottom-nav md:hidden">
    <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span>Home</span>
    </a>

    <a href="{{ route('partitions.index') }}" class="mobile-nav-link {{ request()->routeIs('partitions.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>
        <span>Scores</span>
    </a>

    @auth
        @if(in_array(auth()->user()->role, ['arranger', 'admin']))
            <a href="{{ route('partitions.create') }}" class="mobile-nav-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Create</span>
            </a>
        @endif

        <a href="{{ route('profile.show') }}" class="mobile-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profile</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="mobile-nav-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            <span>Login</span>
        </a>
    @endauth
</nav>

{{-- Auto-dismiss des alerts après 5 secondes --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                alert.style.transition = 'all 0.3s ease';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>

</body>
</html>
