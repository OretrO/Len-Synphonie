<x-layouts.app>
    <x-slot:title>{{ $partition->title ?? 'Partition' }}</x-slot:title>

    <div class="page-container">
        @php
            $currentUser = auth()->user();
        @endphp

        <div class="partition-header mb-6 flex flex-col md:flex-row items-start justify-between gap-6">

            <div class="w-full md:w-3/4">
                <h1 class="partition-title text-3xl font-bold mb-2">{{ $partition->title }}</h1>

                @if($partition->composer)
                    <p class="text-sm text-slate-400 mb-1"><strong>Composer:</strong> {{ $partition->composer }}</p>
                @endif
                <p class="text-sm text-slate-400 mb-1"><strong>Created:</strong> {{ $partition->created_at->format('d/m/Y') }}</p>
                <p class="text-sm text-slate-400 mb-1"><strong>Genre:</strong> {{ $partition->genre ?? 'Non défini' }}</p>

                <div class="flex items-center gap-3 mt-4">
                    @php
                        $author = $partition->user ?? null;
                        // Gestion sécurisée de l'avatar
                        $avatarPath = ($author && !empty($author->avatar))
                            ? asset('storage/' . $author->avatar)
                            : asset('avatars/default.svg'); // Assurez-vous d'avoir une image par défaut
                    @endphp

                    <img src="{{ $avatarPath }}" alt="{{ $author->name ?? 'User' }} avatar" class="w-10 h-10 rounded-full object-cover border border-slate-600" />
                    <div>
                        <div class="text-sm font-medium">{{ $author->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-slate-400">@if($author){{ $author->email }}@endif</div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/4 flex flex-col items-end gap-3">
                @auth
                    {{-- Boutons Modifier / Supprimer (Visible si Admin ou Propriétaire) --}}
                    @if($currentUser instanceof \App\Models\User && ($currentUser->id === ($partition->user_id ?? null) || $currentUser->role === 'admin'))
                        <div class="flex gap-2">
                            <a href="{{ route('partitions.edit', $partition) }}" class="btn btn-outline">Edit</a>

                            <form action="{{ route('partitions.destroy', $partition) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this score?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    @endif

                    {{-- Bouton Créer Arrangement (Visible si Arrangeur ou Admin) --}}
                    @if($currentUser instanceof \App\Models\User && in_array($currentUser->role, ['arranger', 'admin']))
                        @if(
                            \Illuminate\Support\Facades\Route::has('partitions.arrangements.create')
                        )
                            <a href="{{ route('partitions.arrangements.create', ['partition' => $partition->id]) }}" class="btn btn-primary">Create arrangement</a>
                        @endif
                    @endif
                @endauth

                <a href="{{ route('partitions.index') }}" class="btn btn-outline text-sm">← Back to list</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="card">
                    <h2 class="card-title text-xl font-bold mb-4">Score details</h2>

                    @if($partition->description)
                        <div class="prose prose-invert mb-4 text-slate-300">
                            {{ $partition->description }}
                        </div>
                    @endif

                    <div class="bg-slate-800 rounded-lg p-4 mt-4 border border-slate-700">
                        <h3 class="text-sm font-semibold mb-3 text-slate-200 uppercase tracking-wider">Files</h3>
                        <div class="flex flex-wrap gap-3">

                            {{-- Fichier PDF (Visuel) --}}
                            @if(!empty($partition->musicpdf_file_path))
                                <a href="{{ route('partitions.file', ['partition' => $partition, 'type' => 'pdf']) }}" target="_blank" class="btn btn-primary flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View PDF Sheet
                                </a>
                            @else
                                <span class="text-xs text-slate-500 italic">No PDF available</span>
                            @endif

                            {{-- Fichier XML (Source) --}}
                            @if(!empty($partition->musicxml_file_path))
                                <a href="{{ route('partitions.file', ['partition' => $partition, 'type' => 'xml']) }}" download class="btn btn-outline flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download MusicXML
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h3 class="card-title text-xl font-bold mb-4">Arrangements</h3>

                    @if($partition->arrangements && $partition->arrangements->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($partition->arrangements as $arrangement)
                                <div class="bg-slate-800 p-4 rounded border border-slate-700 flex flex-col justify-between h-full">

                                    {{-- Informations de l'arrangement --}}
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h4 class="font-bold text-white">{{ $arrangement->name ?? 'Sans titre' }}</h4>
                                            @if(isset($arrangement->status))
                                                <span class="text-xs px-2 py-0.5 rounded bg-slate-700 text-slate-300">
                                    {{ $arrangement->status }}
                                </span>
                                            @endif
                                        </div>

                                        <div class="text-xs text-slate-400 mt-2 flex flex-col gap-1">
                                            <span>Arrangeur : {{ $arrangement->creator->name ?? 'Inconnu' }}</span>
                                            <span>Date : {{ $arrangement->created_at->format('d/m/Y') }}</span>
                                            {{-- Si la méthode likesCount existe --}}
                                            @if(method_exists($arrangement, 'likesCount'))
                                                <span>Popularité : {{ $arrangement->likesCount() }} likes</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Actions (Boutons) --}}
                                    <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-700">

                                        {{-- Bouton VOIR --}}
                                        <a href="{{ route('arrangements.show', $arrangement) }}" class="btn btn-outline btn-small text-xs px-3 py-1">
                                            Voir
                                        </a>

                                        {{-- Bouton MODIFIER (Si autorisé) --}}
                                        @can('update', $arrangement)
                                            <a href="{{ route('arrangements.edit', $arrangement) }}" class="btn btn-outline btn-small text-xs px-3 py-1">
                                                Éditer
                                            </a>
                                        @endcan

                                        {{-- Bouton SUPPRIMER (Si autorisé) --}}
                                        @can('delete', $arrangement)
                                            <form action="{{ route('arrangements.destroy', $arrangement) }}"
                                                  method="POST"
                                                  class="ml-auto"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet arrangement ? Cette action est irréversible.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400 transition p-1" title="Supprimer l'arrangement">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-slate-800/50 rounded-lg border border-dashed border-slate-700">
                            <p class="text-slate-400 italic">Aucun arrangement pour le moment.</p>
                            @auth
                                @if(auth()->user()->role === 'arranger' || auth()->user()->role === 'admin')
                                    <p class="text-xs mt-2 text-slate-500">Soyez le premier à en créer un !</p>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
                <div class="card">
                    <h3 class="card-title text-xl font-bold mb-4">Comments ({{ $partition->comments?->count() ?? 0 }})</h3>

                    @auth
                        <form action="{{ url('/comments') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="partition_id" value="{{ $partition->id }}">
                            <textarea name="content" rows="3" class="w-full bg-slate-900 border-slate-700 rounded text-slate-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Write a comment..."></textarea>
                            <div class="flex justify-end mt-2">
                                <button class="btn btn-primary text-sm" type="submit">Post comment</button>
                            </div>
                        </form>
                    @else
                        <div class="bg-indigo-900/20 text-indigo-200 p-4 rounded-lg mb-4 text-sm text-center">
                            Please <a href="{{ route('login') }}" class="underline font-bold">log in</a> to post comments.
                        </div>
                    @endauth

                    <div class="space-y-6">
                        @forelse($partition->comments ?? [] as $comment)
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-300 font-bold">
                                        {{ substr($comment->user->name ?? 'A', 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-slate-200">{{ $comment->user->name ?? 'User' }}</span>
                                        <span class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-400 mt-1 text-sm">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm italic">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <aside class="space-y-6">
                <div class="card">
                    <h4 class="font-bold text-white mb-3 border-b border-slate-700 pb-2">Stats</h4>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-slate-400 text-sm">Views</span>
                        <span class="font-mono text-white">{{ $partition->views ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 text-sm">Likes</span>
                        <span class="font-mono text-white">{{ $partition->appreciations?->count() ?? 0 }}</span>
                    </div>
                </div>

                @if(isset($partition->instruments) && $partition->instruments->count())
                    <div class="card">
                        <h4 class="font-bold text-white mb-3 border-b border-slate-700 pb-2">Instruments</h4>
                        <ul class="text-sm text-slate-400 space-y-1">
                            @foreach($partition->instruments as $inst)
                                <li>{{ $inst->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>

        </div>
    </div>

    {{-- Delete partition modal --}}
    <x-modal-delete-partition :partition="$partition" />
</x-layouts.app>
