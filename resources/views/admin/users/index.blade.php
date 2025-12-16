<x-layouts.app>
    <x-slot:title>User management</x-slot:title>

    <div class="page-container">
        <div class="page-header flex items-center justify-between">
            <div>
                <h1 class="page-title">User management</h1>
                <p class="page-subtitle">Manage accounts, roles and avatars.</p>
            </div>
        </div>

        <div class="card overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="text-left py-2 pr-4">Name</th>
                        <th class="text-left py-2 pr-4">Email</th>
                        <th class="text-left py-2 pr-4">Role</th>
                        <th class="text-left py-2 pr-4">Created</th>
                        <th class="text-right py-2 pl-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($users as $user)
                        <tr>
                            <td class="py-2 pr-4 flex items-center gap-2">
                                @php
                                    $avatar = $user->avatar;
                                    $avatarPath = $avatar && $avatar !== 'avatars/default.svg' ? asset('storage/' . $avatar) : null;
                                @endphp
                                <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center bg-slate-800">
                                    @if($avatarPath)
                                        <img src="{{ $avatarPath }}" alt="" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    @endif
                                    <svg class="w-4 h-4 text-slate-400 {{ $avatarPath ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span>{{ $user->name }}</span>
                            </td>
                            <td class="py-2 pr-4 text-slate-300">{{ $user->email }}</td>
                            <td class="py-2 pr-4"><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                            <td class="py-2 pr-4 text-slate-400">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="py-2 pl-4 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-xs">Edit</a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>

