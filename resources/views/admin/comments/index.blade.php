<x-layouts.app>
    <x-slot:title>Comment management</x-slot:title>

    <div class="page-container">
        <div class="page-header flex items-center justify-between">
            <div>
                <h1 class="page-title">Comment management</h1>
                <p class="page-subtitle">Review and moderate comments left on scores and arrangements.</p>
            </div>
        </div>

        <div class="card overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="text-left py-2 pr-4">Author</th>
                        <th class="text-left py-2 pr-4">Content</th>
                        <th class="text-left py-2 pr-4">Target</th>
                        <th class="text-left py-2 pr-4">Date</th>
                        <th class="text-right py-2 pl-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($comments as $comment)
                        <tr>
                            <td class="py-2 pr-4 text-slate-300">{{ $comment->user->name ?? 'Unknown' }}</td>
                            <td class="py-2 pr-4 text-slate-200 max-w-md truncate" title="{{ $comment->content }}">{{ $comment->content }}</td>
                            <td class="py-2 pr-4 text-slate-400">
                                @if($comment->partition)
                                    On score: <a href="{{ route('partitions.show', $comment->partition) }}" class="link">{{ $comment->partition->title }}</a>
                                @elseif($comment->arrangement)
                                    On arrangement: <span class="text-slate-200">{{ $comment->arrangement->name }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-2 pr-4 text-slate-400">{{ $comment->created_at->diffForHumans() }}</td>
                            <td class="py-2 pl-4 text-right">
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>

