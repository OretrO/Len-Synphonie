<x-layouts.app title="{{ $arrangement->name }} - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">{{ $arrangement->name }}</h1>

            <p class="card-text">Partition ID: {{ $arrangement->partition_id }}</p>

            {{-- Audio Player Section --}}
            <div class="card-section" style="margin: 20px 0;">
                <h3 style="margin-bottom: 10px;">🎵 Audio Player</h3>

                @if ($arrangement->status === 'completed' && $arrangement->audio_file_path)
                    {{-- Extract filename and arrangement ID from path (e.g., "arrangements/55/69418277145fa.wav") --}}
                    @php
                        $pathParts = explode('/', $arrangement->audio_file_path);
                        // Path format: "arrangements/{id}/filename.wav"
                        // So $pathParts[0] = "arrangements", $pathParts[1] = "{id}", $pathParts[2] = "filename.wav"
                        $arrangementId = $arrangement->id; // Use the arrangement ID directly
                        $filename = end($pathParts);
                        $audioUrl = route('audio.stream', ['arrangementId' => $arrangementId, 'filename' => $filename]);
                    @endphp
                    
                    <div class="audio-player-container" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border-radius: 12px; padding: 20px; margin-bottom: 15px;">
                        <audio id="arrangement-audio-{{ $arrangement->id }}" 
                               controls 
                               preload="none"
                               style="width: 100%; margin-bottom: 15px;">
                            <source src="{{ $audioUrl }}" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                        
                        {{-- Debug info --}}
                        <div style="font-size: 11px; color: #666; margin-top: 5px; padding: 8px; background: rgba(0,0,0,0.1); border-radius: 4px;">
                            <div><strong>Audio URL:</strong> <a href="{{ $audioUrl }}" target="_blank" style="color: #58a6ff;">{{ $audioUrl }}</a></div>
                            <div><strong>Test:</strong> <a href="{{ $audioUrl }}" target="_blank" style="color: #58a6ff;">Cliquez ici pour tester l'URL</a></div>
                            <div><strong>File path:</strong> {{ $arrangement->audio_file_path }}</div>
                            <div><strong>Arrangement ID:</strong> {{ $arrangementId }}</div>
                            <div><strong>Filename:</strong> {{ $filename }}</div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <button onclick="playAudio({{ $arrangement->id }})" class="btn btn-primary" style="font-size: 13px; padding: 8px 16px;">
                                ▶️ Play
                            </button>
                            <button onclick="pauseAudio({{ $arrangement->id }})" class="btn btn-outline" style="font-size: 13px; padding: 8px 16px;">
                                ⏸️ Pause
                            </button>
                            <button onclick="restartAudio({{ $arrangement->id }})" class="btn btn-outline" style="font-size: 13px; padding: 8px 16px;">
                                ⏮️ Restart
                            </button>
                            <a href="{{ route('audio.download', ['arrangementId' => $arrangementId, 'filename' => $filename]) }}" class="btn btn-outline" style="font-size: 13px; padding: 8px 16px; text-decoration: none;">
                                ⬇️ Download WAV
                            </a>
                        </div>
                        
                        <p style="color: var(--color-success); font-size: 14px; margin-top: 15px; margin-bottom: 0;">
                            ✅ Audio is ready to play
                        </p>
                        
                        <div id="audio-error-{{ $arrangement->id }}" style="color: var(--color-error); font-size: 12px; margin-top: 10px; display: none;"></div>
                    </div>
                    
                    <script>
                        function playAudio(arrangementId) {
                            const audio = document.getElementById('arrangement-audio-' + arrangementId);
                            const errorDiv = document.getElementById('audio-error-' + arrangementId);
                            
                            if (audio) {
                                audio.play().catch(function(error) {
                                    console.error('Error playing audio:', error);
                                    errorDiv.textContent = 'Erreur de lecture: ' + error.message;
                                    errorDiv.style.display = 'block';
                                });
                            }
                        }
                        
                        function pauseAudio(arrangementId) {
                            const audio = document.getElementById('arrangement-audio-' + arrangementId);
                            if (audio) {
                                audio.pause();
                            }
                        }
                        
                        function restartAudio(arrangementId) {
                            const audio = document.getElementById('arrangement-audio-' + arrangementId);
                            if (audio) {
                                audio.currentTime = 0;
                                audio.play().catch(function(error) {
                                    console.error('Error playing audio:', error);
                                });
                            }
                        }
                        
                        // Add error handler
                        document.addEventListener('DOMContentLoaded', function() {
                            const audio = document.getElementById('arrangement-audio-{{ $arrangement->id }}');
                            if (audio) {
                                audio.addEventListener('error', function(e) {
                                    console.error('Audio error:', e);
                                    const errorDiv = document.getElementById('audio-error-{{ $arrangement->id }}');
                                    if (errorDiv) {
                                        errorDiv.textContent = 'Erreur de chargement audio. Vérifiez la console pour plus de détails.';
                                        errorDiv.style.display = 'block';
                                    }
                                });
                                
                                audio.addEventListener('loadedmetadata', function() {
                                    console.log('Audio metadata loaded successfully');
                                });
                                
                                audio.addEventListener('canplay', function() {
                                    console.log('Audio can play');
                                });
                            }
                        });
                    </script>
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

