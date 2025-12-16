<x-layouts.app title="Edit partition - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Edit score</h1>

            <form action="{{ route('partitions.update', $partition) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-input"
                        value="{{ old('title', $partition->title) }}"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="composer" class="form-label">Composer</label>
                    <input
                        type="text"
                        name="composer"
                        id="composer"
                        class="form-input"
                        value="{{ old('composer', $partition->composer) }}"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

