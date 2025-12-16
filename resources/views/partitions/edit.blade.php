<x-layouts.app title="Edit partition - LenSymphony">
    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Edit score</h1>
            <p class="page-subtitle">Modify your composition details and files.</p>
        </div>

        <div class="card">
            @if ($errors->any())
                <div class="mb-4 alert alert-error">
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <strong>Validation errors</strong>
                        <ul class="alert-list mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('partitions.update', $partition) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="title" class="form-label">Score title <span class="text-red-400">*</span></label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-input"
                                value="{{ old('title', $partition->title) }}"
                                required
                                minlength="3"
                                maxlength="50"
                                placeholder="e.g. Symphony No. 5"
                            >
                            @error('title') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="composer" class="form-label">Composer / Author <span class="text-red-400">*</span></label>
                            <input
                                type="text"
                                name="composer"
                                id="composer"
                                class="form-input"
                                value="{{ old('composer', $partition->composer) }}"
                                required
                                minlength="3"
                                maxlength="50"
                                placeholder="e.g. Ludwig van Beethoven"
                            >
                            @error('composer') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="genre" class="form-label">Genre <span class="text-red-400">*</span></label>
                            <input
                                type="text"
                                name="genre"
                                id="genre"
                                class="form-input"
                                value="{{ old('genre', $partition->genre) }}"
                                required
                                maxlength="20"
                                placeholder="e.g. Classical, Jazz, Rock"
                            >
                            @error('genre') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                maxlength="500"
                                class="form-input min-h-[120px]"
                                placeholder="Context, story behind the piece, performance notes..."
                            >{{ old('description', $partition->description) }}</textarea>
                            <p class="form-hint">Maximum 500 characters.</p>
                            @error('description') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="form-group">
                            <label for="musicxml_file" class="form-label">MusicXML file (.xml / .musicxml) (optional)</label>
                            <p class="text-sm text-slate-400 mb-2">Current file: <code class="text-xs bg-slate-800 px-2 py-1 rounded">{{ basename($partition->musicxml_file_path) }}</code></p>
                            <input
                                type="file"
                                name="musicxml_file"
                                id="musicxml_file"
                                accept=".xml,.musicxml"
                                class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-800 file:text-slate-100 hover:file:bg-slate-700"
                            >
                            <p class="form-hint">
                                <strong>⚠️ Warning:</strong> Uploading a new MusicXML file will <strong>delete all associated arrangements</strong>.
                            </p>
                            @error('musicxml_file') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="pdf_file" class="form-label">Score PDF (optional)</label>
                            <p class="text-sm text-slate-400 mb-2">Current file: <code class="text-xs bg-slate-800 px-2 py-1 rounded">{{ basename($partition->musicpdf_file_path) }}</code></p>
                            <input
                                type="file"
                                name="pdf_file"
                                id="pdf_file"
                                accept=".pdf"
                                class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-800 file:text-slate-100 hover:file:bg-slate-700"
                            >
                            <p class="form-hint">Used to display the sheet music in the application.</p>
                            @error('pdf_file') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('partitions.show', $partition) }}" class="btn btn-outline">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

