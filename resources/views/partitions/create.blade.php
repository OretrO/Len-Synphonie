<x-layouts.app>
    <x-slot:title>Create score</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Create a new score</h1>
            <p class="page-subtitle">Upload your MusicXML and PDF files to share your composition.</p>
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

            <form action="{{ route('partitions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="title" class="form-label">Score title <span class="text-red-400">*</span></label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-input"
                                value="{{ old('title') }}"
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
                                value="{{ old('composer') }}"
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
                                value="{{ old('genre') }}"
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
                            >{{ old('description') }}</textarea>
                            <p class="form-hint">Maximum 500 characters.</p>
                            @error('description') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="form-group">
                            <label for="xml_file" class="form-label">MusicXML file (.xml / .musicxml) <span class="text-red-400">*</span></label>
                            <input
                                type="file"
                                name="xml_file"
                                id="xml_file"
                                required
                                accept=".xml,.musicxml"
                                class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-800 file:text-slate-100 hover:file:bg-slate-700"
                            >
                            <p class="form-hint">Source file used for playback and arrangements.</p>
                            @error('xml_file') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="pdf_file" class="form-label">Score PDF (visuel) <span class="text-red-400">*</span></label>
                            <input
                                type="file"
                                name="pdf_file"
                                id="pdf_file"
                                required
                                accept=".pdf"
                                class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-800 file:text-slate-100 hover:file:bg-slate-700"
                            >
                            <p class="form-hint">Used to display the sheet music in the application.</p>
                            @error('pdf_file') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('partitions.index') }}" class="btn btn-outline">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save score
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
