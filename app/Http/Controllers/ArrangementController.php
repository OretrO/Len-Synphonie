<?php

namespace App\Http\Controllers;

use App\Models\Arrangement;
use App\Models\Partition;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArrangementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // OPTIONAL: list of arrangements (admin / pager)
    public function index()
    {
        $arrangements = Arrangement::with(['creator', 'partition'])->orderByDesc('created_at')->paginate(20);
        return view('arrangements.index', compact('arrangements'));
    }

    // Show create form for a given partition OR global create (partition optional)
    public function create(Partition $partition = null)
    {
        $user = Auth::user();
        if (!($user instanceof \App\Models\User) || !in_array($user->role, ['arranger', 'admin'])) {
            abort(403);
        }

        $instruments = Instrument::orderBy('name')->get();

        if ($partition) {
            return view('arrangements.create', compact('partition', 'instruments'));
        }

        // Global create: pass list of partitions to choose from
        $partitions = Partition::orderBy('title')->get();
        return view('arrangements.create', compact('partitions', 'instruments'));
    }

    // Store new arrangement (nested to partition or global)
    public function store(Request $request, Partition $partition = null)
    {
        $user = Auth::user();
        if (!($user instanceof \App\Models\User) || !in_array($user->role, ['arranger', 'admin'])) {
            abort(403);
        }

        // If partition not provided via route, expect partition_id in request
        if (!$partition) {
            $request->validate(['partition_id' => ['required', 'integer', 'exists:partitions,id']]);
            $partition = Partition::findOrFail($request->input('partition_id'));
        }

        $rules = [
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'instruments' => ['required', 'array', 'min:1'],
            'instruments.*' => ['integer', 'exists:instruments,id'],
        ];

        $validated = $request->validate($rules);

        $arrangement = Arrangement::create([
            'partition_id' => $partition->id,
            'creator_id' => $user->id,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'instruments_config' => $validated['instruments'],
            'audio_file_path' => null,
            'status' => 'pending',
        ]);

        // Attach instruments with pivot track number (use submitted order)
        $sync = [];
        foreach ($validated['instruments'] as $idx => $instId) {
            $sync[$instId] = ['track_number' => $idx + 1];
        }
        $arrangement->instruments()->sync($sync);

        // Placeholder: dispatch background job to generate WAV
        Log::info('Arrangement created, dispatch job to generate audio', ['arrangement_id' => $arrangement->id]);

        return redirect()->route('partitions.show', $partition)->with('success', 'Arrangement created and audio generation queued.');
    }

    // Show a single arrangement
    public function show(Arrangement $arrangement)
    {
        $arrangement->load(['creator', 'instruments', 'partition', 'comments']);
        return view('arrangements.show', compact('arrangement'));
    }

    // Edit form
    public function edit(Arrangement $arrangement)
    {
        $this->authorize('update', $arrangement);

        $instruments = Instrument::orderBy('name')->get();
        return view('arrangements.edit', compact('arrangement', 'instruments'));
    }

    // Update arrangement
    public function update(Request $request, Arrangement $arrangement)
    {
        $this->authorize('update', $arrangement);

        $rules = [
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'instruments' => ['required', 'array', 'min:1'],
            'instruments.*' => ['integer', 'exists:instruments,id'],
        ];

        $validated = $request->validate($rules);

        $arrangement->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'instruments_config' => $validated['instruments'],
            'status' => 'pending', // mark for re-generation
        ]);

        // Sync instruments pivot
        $sync = [];
        foreach ($validated['instruments'] as $idx => $instId) {
            $sync[$instId] = ['track_number' => $idx + 1];
        }
        $arrangement->instruments()->sync($sync);

        // Log / dispatch regeneration job
        Log::info('Arrangement updated, dispatch regeneration job', ['arrangement_id' => $arrangement->id]);

        return redirect()->route('arrangements.show', $arrangement)->with('success', 'Arrangement updated and audio regeneration queued.');
    }

    // Delete arrangement
    public function destroy(Arrangement $arrangement)
    {
        $this->authorize('delete', $arrangement);

        // Delete associated audio file if exists (public disk)
        if ($arrangement->audio_file_path && Storage::disk('public')->exists($arrangement->audio_file_path)) {
            Storage::disk('public')->delete($arrangement->audio_file_path);
        }

        $partitionId = $arrangement->partition_id;

        $arrangement->instruments()->detach();
        $arrangement->comments()->delete();
        $arrangement->appreciations()->delete();
        $arrangement->delete();

        return redirect()->route('partitions.show', $partitionId)->with('success', 'Arrangement deleted successfully.');
    }
}
