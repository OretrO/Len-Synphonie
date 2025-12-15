@props(['partition'])

<div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-300 flex flex-col h-full">

    <div class="h-32 bg-indigo-50 flex items-center justify-center border-b border-gray-100">
        <svg class="h-12 w-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>
    </div>

    <div class="p-4 flex-grow">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
            {{ $partition->genre ?? 'Non classé' }}
        </span>

        <h3 class="text-lg font-bold text-gray-900 truncate" title="{{ $partition->title }}">
            {{ $partition->title }}
        </h3>

        <p class="text-sm text-gray-600 mb-4">
            Par <span class="font-medium">{{ $partition->composer }}</span>
        </p>

        <div class="flex items-center justify-between text-xs text-gray-500 mt-2">
            <div class="flex items-center" title="Date d'ajout">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ $partition->created_at->format('d/m/Y') }}
            </div>

            <div class="flex items-center" title="Nombre d'arrangements">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                {{ $partition->arrangements_count ?? 0 }}
            </div>
        </div>
    </div>

    <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex justify-between items-center">

        @auth
            <a href="{{ route('partitions.show', $partition) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold transition">
                Voir détails
            </a>
        @else
            <span class="text-gray-400 text-xs italic">Connectez-vous pour voir</span>
        @endauth

        <div class="flex space-x-2">
            @can('update', $partition)
                <a href="{{ route('partitions.edit', $partition) }}" class="text-yellow-600 hover:text-yellow-800" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
            @endcan

            @can('delete', $partition)
                <form action="{{ route('partitions.destroy', $partition) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette partition ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>
