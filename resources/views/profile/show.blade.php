<x-layouts.app>
    <x-slot:title>Profil</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Mon profil</h1>
        </div>

        <div class="card">
            <div class="flex items-center gap-6">
                <div class="w-28 h-28 rounded-full overflow-hidden border border-indigo-500/20">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <svg class="w-full h-full p-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    @endif
                </div>

                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-slate-400">{{ $user->email }}</p>
                    <p class="mt-2">
                        <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Mes partitions</h3>
                <div class="partition-grid">
                    @foreach($user->partitions()->limit(6)->get() as $partition)
                        <x-card-partition :partition="$partition" />
                    @endforeach
                </div>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline">Modifier le profil</a>
            </div>
        </div>
    </div>
</x-layouts.app>
