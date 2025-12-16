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
        // Vérifier que l'utilisateur est arranger ou admin
        if (!in_array(optional(Auth::user())->role, ['arranger', 'admin'])) {
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
        if (!in_array(optional(Auth::user())->role, ['arranger', 'admin'])) {
            abort(403, 'Accès refusé.');
        }
        $this->authorize('create', Partition::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'musicxml_file' => 'required|file|mimes:xml,musicxml|max:10240',
            'genre' => 'required|string|max:100',
            'title' => ['required', 'string', 'max:255'],
            'composer' => ['nullable', 'string', 'max:255'],
        ]);

        // Upload du fichier MusicXML
        $path = $request->file('musicxml_file')->store('partitions', 'public');

        $partition = Partition::create([
            'title' => $validated['title'],
            'composer' => $validated['composer'],
            'musicxml_file_path' => $path,
            'user_id' => Auth::id(),
            'genre' => $validated['genre'],
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
        // Vérifier les permissions : propriétaire ou admin
        if (optional(Auth::user())->id !== $partition->user_id && optional(Auth::user())->role !== 'admin') {
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
        if (optional(Auth::user())->id !== $partition->user_id && optional(Auth::user())->role !== 'admin') {
            abort(403, 'Vous ne pouvez modifier que vos propres partitions.');
        }
        $this->authorize('update', $partition);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'composer' => ['nullable', 'string', 'max:255'],
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'musicxml_file' => 'nullable|file|mimes:xml,musicxml|max:10240',
            'genre' => 'required|string|max:100',
        ]);

        $partition->title = $validated['title'];
        $partition->composer = $validated['composer'];
        $partition->genre = $validated['genre'];

        // Si un nouveau fichier est uploadé
        if ($request->hasFile('musicxml_file')) {
            $path = $request->file('musicxml_file')->store('partitions', 'public');
            $partition->musicxml_file_path = $path;
        }

        $partition->save();
        $partition->update($validated);

        return redirect()->route('partitions.show', $partition)
            ->with('success', 'Partition mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partition $partition)
    {
        // Vérifier les permissions : propriétaire ou admin
        if (optional(Auth::user())->id !== $partition->user_id && optional(Auth::user())->role !== 'admin') {
            abort(403, 'Vous ne pouvez supprimer que vos propres partitions.');
        }

        $partition->delete();

        return redirect()->route('partitions.index');
    }
    public function Search(Request $request)
    {
        $query = trim((string) $request->input('query'));
        $composerFilter = trim((string) $request->input('composer'));
        $scope = $request->input('scope', 'all');

        $qb = Partition::with('user');

        if ($query !== '') {
            if ($scope === 'title') {
                $qb->where('title', 'like', '%' . $query . '%');
            } elseif ($scope === 'composer') {
                $qb->where('composer', 'like', '%' . $query . '%');
            } elseif ($scope === 'genre') {
                $qb->where('genre', 'like', '%' . $query . '%');
            } else {
                $qb->where(function ($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('composer', 'like', '%' . $query . '%')
                      ->orWhere('genre', 'like', '%' . $query . '%');
                });
            }
        }

        if ($composerFilter !== '') {
            // filtre dédié sur le champ composer
            $qb->where('composer', 'like', '%' . $composerFilter . '%');
        }

        $partitions = $qb->latest()->paginate(12);

        return view('partitions.index', compact('partitions'));
    }
}
