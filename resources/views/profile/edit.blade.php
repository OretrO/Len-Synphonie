@php
    use Illuminate\Support\Facades\Storage;
    $avatarPath = $user->avatar && $user->avatar !== 'avatars/default.svg' 
        ? (Storage::disk('public')->exists($user->avatar) ? asset('storage/' . $user->avatar) : null)
        : null;
@endphp

<x-layouts.app>
    <x-slot:title>Edit Profile</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Edit Profile</h1>
        </div>

        <div class="card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="flex items-center gap-6">
                    <div class="w-28 h-28 rounded-full overflow-hidden border-2 relative flex items-center justify-center" style="border-color: var(--color-border); background: var(--color-surface);">
                        @if($avatarPath)
                            <img src="{{ $avatarPath }}" alt="Avatar" class="w-full h-full object-cover" id="avatarPreviewImg" onerror="this.style.display='none'; document.getElementById('avatarPreviewSvg').style.display='flex';">
                        @endif
                        <svg id="avatarPreviewSvg" class="w-full h-full p-4 {{ $avatarPath ? 'hidden' : '' }}" style="color: var(--color-text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <input type="file" name="avatar" id="avatarInput" class="absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/png,image/jpeg,image/jpg" onchange="previewAvatar(this)">
                    </div>

                    <div class="flex-1">
                        <label class="form-label">Username</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}">

                        <label class="form-label mt-4">Email address</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>

    </div>

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.getElementById('avatarPreviewImg');
                    const svg = document.getElementById('avatarPreviewSvg');
                    const container = input.parentElement;
                    
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'avatarPreviewImg';
                        img.className = 'w-full h-full object-cover';
                        img.alt = 'Avatar';
                        img.onerror = function() {
                            this.style.display = 'none';
                            if (svg) svg.style.display = 'flex';
                        };
                        container.insertBefore(img, svg);
                    }
                    
                    img.src = e.target.result;
                    img.style.display = 'block';
                    if (svg) svg.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-layouts.app>
