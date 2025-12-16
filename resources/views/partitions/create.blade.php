<x-layouts.app title="Create partition - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Create a new score</h1>

            <form action="{{ route('partitions.store') }}" method="POST" class="form">
                @csrf

                <div class="form-field">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-input"
                        value="{{ old('title') }}"
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
                        value="{{ old('composer') }}"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

