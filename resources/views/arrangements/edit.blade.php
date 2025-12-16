<x-layouts.app title="Edit arrangement - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Edit arrangement</h1>

            <form action="{{ route('arrangements.update', $arrangement) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-input"
                        value="{{ old('name', $arrangement->name) }}"
                        required
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

