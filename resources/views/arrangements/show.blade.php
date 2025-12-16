<x-layouts.app title="{{ $arrangement->name }} - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">{{ $arrangement->name }}</h1>

            <p class="card-text">Partition ID: {{ $arrangement->partition_id }}</p>

            {{-- Audio Player Section --}}
            <div class="card-section" style="margin: 20px 0;">
                <h3 style="margin-bottom: 10px;">🎵 Audio Player</h3>

                @if ($arrangement->status === 'completed' && $arrangement->audio_file_path)
                    {{-- Extract filename from path (e.g., "arrangements/55/69418277145fa.wav" -> "69418277145fa.wav") --}}
                    @php
                        $pathParts = explode('/', $arrangement->audio_file_path);
                        $arrangementId = $pathParts[1] ?? $arrangement->id;
                        $filename = end($pathParts);
                        $audioUrl = route('audio.stream', ['arrangementId' => $arrangementId, 'filename' => $filename]);
                    @endphp
                    <audio controls style="width: 100%; margin-bottom: 10px;">
                        <source src="{{ $audioUrl }}" type="audio/wav">
                        Your browser does not support the audio element.
                    </audio>
                    <p style="color: #22863a; font-size: 14px;">✅ Audio is ready to play</p>

                    {{-- Download button --}}
                    <a href="{{ route('audio.download', ['arrangementId' => $arrangementId, 'filename' => $filename]) }}" class="btn btn-outline" style="font-size: 13px; padding: 8px 12px; margin-top: 10px;">
                        ⬇️ Download Audio
                    </a>
                @elseif ($arrangement->status === 'processing')
                    <div style="padding: 15px; background-color: #fff3cd; border-radius: 4px; margin-bottom: 10px;">
                        <p style="margin: 0; color: #856404;">⏳ Audio generation in progress...</p>
                        <p style="margin: 5px 0 0 0; font-size: 13px; color: #856404;">Please refresh the page in a moment.</p>
                    </div>
                @elseif ($arrangement->status === 'failed')
                    <div style="padding: 15px; background-color: #f8d7da; border-radius: 4px; margin-bottom: 10px;">
                        <p style="margin: 0; color: #721c24;">❌ Audio generation failed</p>
                        @if ($arrangement->audio_generation_error)
                            <p style="margin: 5px 0 0 0; font-size: 13px; color: #721c24;">{{ $arrangement->audio_generation_error }}</p>
                        @endif
                    </div>
                    @can('update', $arrangement)
                        <form action="{{ route('arrangements.update', $arrangement) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $arrangement->name }}">
                            <input type="hidden" name="description" value="{{ $arrangement->description }}">
                            <input type="hidden" name="instruments[]" value="{{ implode(',', $arrangement->instruments_config ?? []) }}">
                            <button type="submit" class="btn btn-warning" style="font-size: 13px; padding: 8px 12px;">Retry Generation</button>
                        </form>
                    @endcan
                @else
                    <div style="padding: 15px; background-color: #d1ecf1; border-radius: 4px; margin-bottom: 10px;">
                        <p style="margin: 0; color: #0c5460;">⏱️ Audio generation pending...</p>
                        <p style="margin: 5px 0 0 0; font-size: 13px; color: #0c5460;">Your audio will be generated soon.</p>
                    </div>
                @endif
            </div>

            {{-- Arrangement Details --}}
            <div class="card-section" style="margin: 20px 0;">
                <h3 style="margin-bottom: 10px;">📋 Details</h3>
                @if ($arrangement->description)
                    <p class="card-text"><strong>Description:</strong> {{ $arrangement->description }}</p>
                @endif
                <p class="card-text"><strong>Creator:</strong> {{ $arrangement->creator->name ?? 'Unknown' }}</p>
                <p class="card-text"><strong>Created:</strong> {{ $arrangement->created_at->format('d/m/Y H:i') }}</p>
                @if ($arrangement->instruments->count() > 0)
                    <p class="card-text"><strong>Instruments:</strong></p>
                    <ul style="margin: 5px 0 0 20px;">
                        @foreach ($arrangement->instruments as $instrument)
                            <li>{{ $instrument->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="card-actions">
                @can('update', $arrangement)
                    <a href="{{ route('arrangements.edit', $arrangement) }}" class="btn btn-outline">Edit arrangement</a>
                @endcan

                @can('delete', $arrangement)
                    <form action="{{ route('arrangements.destroy', $arrangement) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete arrangement</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-layouts.app>

