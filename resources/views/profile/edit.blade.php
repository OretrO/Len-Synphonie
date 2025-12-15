<x-layouts.app>
    <x-slot:title>Éditer le profil</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Éditer le profil</h1>
        </div>

        <div class="card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="flex items-center gap-6">
                    <div class="w-28 h-28 rounded-full overflow-hidden border border-indigo-500/20 relative">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <svg class="w-full h-full p-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                        <input type="file" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/png,image/jpeg,image/jpg">
                    </div>

                    <div class="flex-1">
                        <label class="form-label">Nom d'utilisateur</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}">

                        <label class="form-label mt-4">Adresse e-mail</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>

    </div>
</x-layouts.app>
