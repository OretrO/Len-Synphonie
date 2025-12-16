<?php

namespace App\Http\Controllers;

use App\Models\Arrangement;
use Illuminate\Http\Request;

class ArrangementController extends Controller
{
    public function index()
    {
        $arrangements = Arrangement::latest()->paginate(12);

        return view('arrangements.index', compact('arrangements'));
    }

    public function show(Arrangement $arrangement)
    {
        $this->authorize('view', $arrangement);

        return view('arrangements.show', compact('arrangement'));
    }

    public function create()
    {
        $this->authorize('create', Arrangement::class);

        return view('arrangements.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Arrangement::class);

        $validated = $request->validate([
            'partition_id' => ['required', 'integer', 'exists:partitions,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $arrangement = Arrangement::create([
            'partition_id'       => $validated['partition_id'],
            'creator_id'         => $request->user()->id,
            'name'               => $validated['name'],
            'instruments_config' => [],
            'audio_file_path'    => null,
            'status'             => 'draft',
        ]);

        return redirect()->route('arrangements.show', $arrangement)
            ->with('success', 'Arrangement created successfully.');
    }

    public function edit(Arrangement $arrangement)
    {
        $this->authorize('update', $arrangement);

        return view('arrangements.edit', compact('arrangement'));
    }

    public function update(Request $request, Arrangement $arrangement)
    {
        $this->authorize('update', $arrangement);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $arrangement->update($validated);

        return redirect()->route('arrangements.show', $arrangement)
            ->with('success', 'Arrangement updated successfully.');
    }

    public function destroy(Arrangement $arrangement)
    {
        $this->authorize('delete', $arrangement);

        $arrangement->delete();

        return redirect()->route('arrangements.index')
            ->with('success', 'Arrangement deleted successfully.');
    }
}
