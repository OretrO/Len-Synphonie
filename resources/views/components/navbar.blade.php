<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo">
            LenSymphony
        </a>

        <div class="navbar-links">
            <a href="{{ route('home') }}" class="navbar-link">Home</a>
            <a href="{{ route('about') }}" class="navbar-link">About</a>
            <a href="{{ route('contact') }}" class="navbar-link">Contact</a>
            <a href="{{ route('partitions.index') }}" class="navbar-link">Partitions</a>

            @auth
                <a href="{{ route('arrangements.index') }}" class="navbar-link">Arrangements</a>

                {{-- Common navigation for any authenticated user --}}
                <a href="#" class="navbar-link">My account</a>

                {{-- Quick access: create partition for users with permission --}}
                @can('create', App\Models\Partition::class)
                    <a href="{{ route('partitions.create') }}" class="navbar-link">New partition</a>
                @endcan

                {{-- Arranger-specific navigation --}}
                @if(auth()->user()?->role === 'arranger' || auth()->user()?->role === 'admin')
                    <a href="{{ route('partitions.index') }}" class="navbar-link">My partitions</a>
                    <a href="{{ route('arrangements.index') }}" class="navbar-link">My arrangements</a>
                @endif

                {{-- Admin-specific navigation (placeholder for future admin area) --}}
                @if(auth()->user()?->role === 'admin')
                    <a href="#" class="navbar-link">Admin</a>
                @endif

                <form action="#" method="POST" class="navbar-link navbar-logout">
                    @csrf
                    {{-- Replace action with your real logout route when available --}}
                    <button type="submit">Logout</button>
                </form>
            @endauth

            @guest
                {{-- Visitor navigation --}}
                <a href="{{ route('register') }}" class="navbar-link">Register</a>
            @endguest
        </div>
    </div>
</nav>
