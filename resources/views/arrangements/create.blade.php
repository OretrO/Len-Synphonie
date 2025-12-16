<x-layouts.app title="Create arrangement - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Create a new arrangement</h1>

            <form action="{{ route('arrangements.store') }}" method="POST" class="form">
                @csrf

                <div class="form-field">
                    <label for="partition_id" class="form-label">Partition ID</label>
                    <input
                        type="number"
                        name="partition_id"
                        id="partition_id"
                        class="form-input"
                        value="{{ old('partition_id') }}"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-input"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

