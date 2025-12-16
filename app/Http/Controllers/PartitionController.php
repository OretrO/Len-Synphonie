<?php

namespace App\Http\Controllers;

use App\Models\Partition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partitions = Partition::latest()->paginate(12);

        return view('partitions.index', compact('partitions'));
    }

    public function show(Partition $partition)
    {
        $this->authorize('view', $partition);

        return view('partitions.show', compact('partition'));
    }

    public function create()
    {
        $this->authorize('create', Partition::class);

        return view('partitions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Partition::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'composer' => ['nullable', 'string', 'max:255'],
        ]);

        // Upload du fichier MusicXML
        $path = $request->file('musicxml_file')->store('partitions', 'public');

        $partition = Partition::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('partitions.show', $partition);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partition $partition)
    {
        $this->authorize('update', $partition);

        return view('partitions.edit', compact('partition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partition $partition)
    {
        $this->authorize('update', $partition);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'composer' => ['nullable', 'string', 'max:255'],
        ]);

        $partition->update($validated);

        return redirect()->route('partitions.show', $partition)
            ->with('success', 'Partition mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partition $partition)
    {
        $this->authorize('delete', $partition);

        $partition->delete();

        return redirect()->route('partitions.index');
    }
}
