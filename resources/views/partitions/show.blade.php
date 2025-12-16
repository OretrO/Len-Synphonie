<x-layouts.app>
    <x-slot:title>{{ $partition->title ?? 'Partition' }}</x-slot:title>

    <div class="page-container">
        @php
            $currentUser = auth()->user();
        @endphp
        <div class="partition-header mb-6 flex items-start gap-6">
            <div class="w-full md:w-3/4">
                <h1 class="partition-title text-3xl font-bold mb-2">{{ $partition->title }}</h1>
                @if($partition->composer)
                    <p class="text-sm text-slate-400 mb-1"><strong>Composer:</strong> {{ $partition->composer }}</p>
                @endif
                <p class="text-sm text-slate-400 mb-1"><strong>Created:</strong> {{ $partition->created_at->format('d/m/Y') }}</p>

                <div class="flex items-center gap-3 mt-3">
                    @php
                        $author = $partition->user ?? null;
                        $avatarPath = $author && !empty($author->avatar) ? ($author->avatar) : asset('avatars/default.svg');
                    @endphp


            @auth
                @if(auth()->user()->id === $partition->user_id || auth()->user()->role === 'admin')
                    <div class="partition-actions">
                        <a href="{{ route('partitions.edit', $partition) }}" class="btn btn-outline">
                            Modifier
                        </a>
                        <form action="{{ route('partitions.destroy', $partition) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette partition ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                @endif
            @endauth
                    <img src="{{ $avatarPath }}" alt="{{ $author->name ?? 'User' }} avatar" class="navbar-avatar" />
                    <div>
                        <div class="text-sm font-medium">{{ $author->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-slate-400">@if($author){{ $author->email }}@endif</div>
                    </div>
                </div>

            </div>

            <div class="w-full md:w-1/4 flex flex-col items-end gap-3">
                @auth
                    @if($currentUser instanceof \App\Models\User && $currentUser->id === ($partition->user_id ?? null) || ($currentUser instanceof \App\Models\User && $currentUser->role === 'admin'))
                        <div class="partition-actions">
                            <a href="{{ route('partitions.edit', $partition) }}" class="btn btn-outline">Edit</a>

                            <form action="{{ route('partitions.destroy', $partition) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this score?');" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    @endif

                    @if($currentUser instanceof \App\Models\User && in_array($currentUser->role, ['arranger', 'admin']))
                        @if(
                            \Illuminate\Support\Facades\Route::has('arrangements.create')
                        )
                            <a href="{{ route('arrangements.create', ['partition' => $partition->id]) }}" class="btn btn-primary">Create arrangement</a>
                        @endif
                    @endif
                @endauth

                <a href="{{ route('partitions.index') }}" class="btn btn-outline">← Back to list</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card">
                    <h2 class="card-title">Score details</h2>

                    @if($partition->description)
                        <p class="card-text">{{ $partition->description }}</p>
                    @endif

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-400"><strong>Key / Meter:</strong> {{ $partition->key ?? '—' }}</p>
                            <p class="text-sm text-slate-400"><strong>Duration:</strong> {{ $partition->duration ?? '—' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-400"><strong>Difficulty:</strong> {{ $partition->difficulty ?? '—' }}</p>
                            <p class="text-sm text-slate-400"><strong>Tags:</strong>
                                @if($partition->tags)
                                    @foreach(explode(',', $partition->tags) as $tag)
                                        <span class="badge badge-user mr-1">{{ trim($tag) }}</span>
                                    @endforeach
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Files (PDF / Audio) --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Files</h3>
                        <div class="flex flex-col gap-3">
                            @if(!empty($partition->sheet_file_path))
                                <a href="{{ asset($partition->sheet_file_path) }}" target="_blank" class="btn btn-outline">Open sheet (PDF)</a>
                            @endif



            <p class="partition-meta">
                <strong>Created by:</strong> {{ $partition->user->name }}
            </p>
                            @if(!empty($partition->audio_file_path))
                                <audio controls src="{{ asset($partition->audio_file_path) }}" class="w-full mt-2">Your browser does not support the audio element.</audio>
                            @endif
                        </div>
                    </div>

                <p class="partition-meta">
                    <strong>Genre:</strong> {{ $partition->genre }}
                </p>

            <p class="partition-meta">
                <strong>Date:</strong> {{ $partition->created_at->format('d/m/Y') }}
            </p>

        </div>
                </div>

                {{-- Arrangements --}}
                <div class="mt-6 card">
                    <h3 class="card-title">Arrangements</h3>

                    @if($partition->arrangements && $partition->arrangements->count())
                        <div class="arrangements-list mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($partition->arrangements as $arrangement)
                                <div class="partition-card p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="font-semibold">{{ $arrangement->name }}</h4>
                                            <p class="text-xs text-slate-400">Status: <strong class="text-slate-200">{{ $arrangement->status }}</strong></p>
                                            <p class="text-xs text-slate-400">By: {{ $arrangement->creator?->name ?? '—' }}</p>
                                        </div>
                                        <div class="text-xs text-slate-400">{{ $arrangement->created_at->diffForHumans() }}</div>
                                    </div>

                                    @php
                                        $cfg = [];
                                        $raw = $arrangement->instruments_config ?? null;

                                        // Normalize Collections
                                        if ($raw instanceof \Illuminate\Support\Collection) {
                                            $raw = $raw->toArray();
                                        }

                                        // If it's already an array, use it
                                        if (is_array($raw)) {
                                            $cfg = $raw;
                                        }

                                        // If it's a non-empty string, try to decode JSON safely
                                        if (is_string($raw) && strlen(trim($raw)) > 0) {
                                            $decoded = @json_decode($raw, true);
                                            if (is_array($decoded)) {
                                                $cfg = $decoded;
                                            }
                                        }
                                    @endphp

                                    @if(count($cfg))
                                        <div class="mt-3">
                                            <h5 class="text-sm font-semibold">Instruments</h5>
                                            <ul class="text-sm text-slate-400 mt-2 space-y-1">
                                                @foreach($cfg as $inst)
                                                    <li>{{ $inst['name'] ?? 'Instrument' }} — vol: {{ $inst['volume'] ?? '—' }} — pan: {{ $inst['pan'] ?? 0 }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(!empty($arrangement->audio_file_path))
                                        <div class="mt-3">
                                            <audio controls src="{{ asset($arrangement->audio_file_path) }}" class="w-full">Your browser does not support the audio element.</audio>
                                        </div>
                                    @endif

                                    <div class="mt-3 flex items-center gap-2">
                                        @if(\Illuminate\Support\Facades\Route::has('arrangements.show'))
                                            <a href="{{ route('arrangements.show', $arrangement) }}" class="btn btn-outline btn-small">Open</a>
                                        @else
                                            <span class="btn btn-outline btn-small opacity-50 cursor-not-allowed">Open</span>
                                        @endif
                                        @auth
                                            @if($currentUser instanceof \App\Models\User && ($currentUser->id === ($arrangement->creator_id ?? null) || $currentUser->role === 'admin'))
                                                @if(\Illuminate\Support\Facades\Route::has('arrangements.edit'))
                                                    <a href="{{ route('arrangements.edit', $arrangement) }}" class="btn btn-outline btn-small">Edit</a>
                                                @endif
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-400 mt-3 italic">No arrangements yet.</p>
                    @endif
                </div>

                {{-- Comments section --}}
                <div class="mt-6 card">
                    <h3 class="card-title">Comments ({{ $partition->comments?->count() ?? 0 }})</h3>

                    @auth
                        <form action="{{ url('/comments') }}" method="POST" class="mt-4 space-y-3">
                            @csrf
                            <input type="hidden" name="partition_id" value="{{ $partition->id }}">
                            <textarea name="content" rows="3" class="form-input" placeholder="Write a comment..."></textarea>
                            <div class="flex items-center gap-3">
                                <button class="btn btn-primary" type="submit">Post comment</button>
                                <span class="text-sm text-slate-400">Be kind — follow community guidelines.</span>
                            </div>
                        </form>
                    @else
                        <p class="text-slate-400 mt-3">Please <a href="{{ route('login') }}" class="auth-link">log in</a> to post comments.</p>
                    @endauth

                    <div class="mt-4 space-y-4">
                        @foreach($partition->comments ?? [] as $comment)
                            <div class="flex items-start gap-3">
                                @php
                                    $cuser = $comment->user ?? null;
                                    $cavatar = $cuser && !empty($cuser->avatar) ? $cuser->avatar : asset('avatars/default.svg');
                                @endphp
                                <img src="{{ $cavatar }}" alt="avatar" class="w-9 h-9 rounded-full object-cover">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-sm font-medium">{{ $cuser->name ?? 'User' }}</div>
                                            <div class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="text-xs text-slate-400">{{ $comment->appreciations?->count() ?? 0 }} ❤️</div>
                                    </div>

                                    <p class="mt-2 text-slate-200">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Right column: metadata, stats, actions --}}
            <aside class="space-y-4">
                <div class="card">
                    <h4 class="font-semibold mb-3">Instruments used</h4>
                    @if($partition->instruments && $partition->instruments->count())
                        <ul class="text-sm text-slate-400 space-y-1">
                            @foreach($partition->instruments as $inst)
                                <li>{{ $inst->name }} @if($inst->pivot?->role) — <small>{{ $inst->pivot->role }}</small>@endif</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-slate-400 italic">No instruments listed.</p>
                    @endif
                </div>

                <div class="card">
                    <h4 class="font-semibold mb-2">Stats</h4>
                    <p class="text-sm text-slate-400">Views: {{ $partition->views ?? 0 }}</p>
                    <p class="text-sm text-slate-400">Likes: {{ $partition->appreciations?->count() ?? 0 }}</p>
                </div>

                <div class="card">
                    <h4 class="font-semibold mb-2">Actions</h4>
                    <div class="flex flex-col gap-2">
                        @auth
                            <form action="{{ url('/appreciations') }}" method="POST">
                                @csrf
                                <input type="hidden" name="partition_id" value="{{ $partition->id }}">
                                <button class="btn btn-outline" type="submit">Appreciate (Like)</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Log in to like</a>
                        @endauth

                        @if(!empty($partition->downloadable_file_path))
                            <a href="{{ asset($partition->downloadable_file_path) }}" class="btn btn-primary">Download files</a>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>
