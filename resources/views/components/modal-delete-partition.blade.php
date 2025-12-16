@props(['partition'])

<div id="deletePartitionModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-slate-900 rounded-lg p-6 max-w-md w-full mx-4 border border-slate-700 shadow-2xl">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-4">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6v0m7.07-6.07a9 9 0 11-12.14 0M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <h3 class="text-xl font-bold text-white">Delete Score</h3>
        </div>

        <!-- Content -->
        <p class="text-slate-300 mb-4">
            Are you sure you want to delete <strong class="text-white">{{ $partition->title }}</strong>?
        </p>

        <!-- Warning if arrangements exist -->
        @if($partition->arrangements && $partition->arrangements->count() > 0)
            <div class="bg-red-900/30 border border-red-600 rounded-lg p-4 mb-6">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-red-200 font-semibold text-sm">Cannot delete this score</p>
                        <p class="text-red-300 text-xs mt-1">
                            This score has <strong>{{ $partition->arrangements->count() }} arrangement(s)</strong> and cannot be deleted.
                            Please delete all arrangements first.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions (Disabled delete button) -->
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeDeletePartitionModal()"
                        class="px-4 py-2 rounded font-medium text-slate-300 hover:text-slate-100 hover:bg-slate-800 transition">
                    Cancel
                </button>
                <button type="button" disabled
                        class="px-4 py-2 rounded font-medium bg-slate-700 text-slate-400 cursor-not-allowed opacity-50">
                    Delete (Disabled)
                </button>
            </div>
        @else
            <!-- Actions (Normal) -->
            <div class="bg-red-900/20 border border-red-600/30 rounded-lg p-3 mb-6">
                <p class="text-red-200 text-sm">
                    ⚠️ This action cannot be undone. The score will be permanently deleted.
                </p>
            </div>

            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeDeletePartitionModal()"
                        class="px-4 py-2 rounded font-medium text-slate-300 hover:text-slate-100 hover:bg-slate-800 transition">
                    Cancel
                </button>
                <form action="{{ route('partitions.destroy', $partition) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded font-medium bg-red-600 text-white hover:bg-red-700 transition">
                        Delete Score
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
    function openDeletePartitionModal() {
        document.getElementById('deletePartitionModal')?.classList.remove('hidden');
    }

    function closeDeletePartitionModal() {
        document.getElementById('deletePartitionModal')?.classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('deletePartitionModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeletePartitionModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeletePartitionModal();
        }
    });
</script>

