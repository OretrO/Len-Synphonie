<x-layouts.app>
    <x-slot:title>Edit user</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Edit user</h1>
            <p class="page-subtitle">Update name, email, role and avatar.</p>
        </div>

        <div class="card">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex items-start gap-6">
                    @php
                        $avatar = $user->avatar;
                        $avatarPath = $avatar && $avatar !== 'avatars/default.svg' ? asset('storage/' . $avatar) : null;
                    @endphp
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-2 flex items-center justify-center" style="border-color: var(--color-border); background: var(--color-surface);">
                            @if($avatarPath)
                                <img src="{{ $avatarPath }}" alt="Avatar" class="w-full h-full object-cover" id="adminAvatarPreviewImg" onerror="this.style.display='none'; document.getElementById('adminAvatarPreviewSvg').style.display='flex';">
                            @endif
                            <svg id="adminAvatarPreviewSvg" class="w-full h-full p-4 {{ $avatarPath ? 'hidden' : '' }}" style="color: var(--color-text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>

                        <label class="btn btn-outline btn-xs cursor-pointer">
                            Change avatar
                            <input type="file" name="avatar" id="adminAvatarInput" class="hidden" accept="image/png,image/jpeg,image/jpg" onchange="adminPreviewAvatar(this)">
                        </label>

                        @if($avatarPath)
                            <label class="flex items-center gap-2 text-xs text-slate-400 cursor-pointer">
                                <input type="checkbox" name="remove_avatar" value="1" class="rounded border-slate-600 bg-slate-800">
                                <span>Remove avatar</span>
                            </label>
                        @endif
                    </div>

                    <div class="flex-1 space-y-4">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                            @error('name') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                            @error('email') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="role">Role</label>
                            <select name="role" id="role" class="form-input">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="arranger" {{ old('role', $user->role) === 'arranger' ? 'selected' : '' }}>Arranger</option>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                                <option value="visitor" {{ old('role', $user->role) === 'visitor' ? 'selected' : '' }}>Visitor</option>
                            </select>
                            @error('role') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Back</a>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function adminPreviewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.getElementById('adminAvatarPreviewImg');
                    const svg = document.getElementById('adminAvatarPreviewSvg');
                    const container = input.closest('div').previousElementSibling;

                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'adminAvatarPreviewImg';
                        img.className = 'w-full h-full object-cover';
                        img.alt = 'Avatar';
                        img.onerror = function() {
                            this.style.display = 'none';
                            if (svg) svg.style.display = 'flex';
                        };
                        container.innerHTML = '';
                        container.appendChild(img);
                        container.appendChild(svg);
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

