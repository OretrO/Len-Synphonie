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
        $partitions = Partition::with('user')->latest()->paginate(12);
        return view('partitions.index', compact('partitions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier que l'utilisateur est arranger ou admin
        if (!in_array(Auth::user()->role, ['arranger', 'admin'])) {
            abort(403, 'Accès refusé. Seuls les arrangers et admins peuvent créer des partitions.');
        }

        return view('partitions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier que l'utilisateur est arranger ou admin
        if (!in_array(Auth::user()->role, ['arranger', 'admin'])) {
            abort(403, 'Accès refusé.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'musicxml_file' => 'required|file|mimes:xml,musicxml|max:10240',
        ]);

        // Upload du fichier MusicXML
        $path = $request->file('musicxml_file')->store('partitions', 'public');

        $partition = Partition::create([
            'title' => $validated['title'],
            'composer' => $validated['composer'],
            'musicxml_file_path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('partitions.show', $partition)
            ->with('success', 'Partition créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partition $partition)
    {
        $partition->load(['user', 'arrangements']);
        return view('partitions.show', compact('partition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partition $partition)
    {
        // Vérifier les permissions : propriétaire ou admin
        if (Auth::user()->id !== $partition->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Vous ne pouvez modifier que vos propres partitions.');
        }

        return view('partitions.edit', compact('partition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partition $partition)
    {
        // Vérifier les permissions : propriétaire ou admin
        if (Auth::user()->id !== $partition->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Vous ne pouvez modifier que vos propres partitions.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'musicxml_file' => 'nullable|file|mimes:xml,musicxml|max:10240',
        ]);

        $partition->title = $validated['title'];
        $partition->composer = $validated['composer'];

        // Si un nouveau fichier est uploadé
        if ($request->hasFile('musicxml_file')) {
            $path = $request->file('musicxml_file')->store('partitions', 'public');
            $partition->musicxml_file_path = $path;
        }

        $partition->save();

        return redirect()->route('partitions.show', $partition)
            ->with('success', 'Partition mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partition $partition)
    {
        // Vérifier les permissions : propriétaire ou admin
        if (Auth::user()->id !== $partition->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Vous ne pouvez supprimer que vos propres partitions.');
        }

        $partition->delete();

        return redirect()->route('partitions.index')
            ->with('success', 'Partition supprimée avec succès !');
    }
}

