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

        // 1. Validation
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:50',
            'composer' => 'required|string|min:5|max:50',
            'genre' => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
            'xml_file' => 'required|file|extensions:xml,musicxml|max:2048',
            'pdf_file' => 'required|file|mimes:pdf|max:5120',
        ]);

        // 2. Upload des fichiers
        // On stocke les fichiers dans le disque 'public' pour qu'ils soient accessibles
        $xmlPath = $request->file('xml_file')->store('partitions/xml', 'public');
        $pdfPath = $request->file('pdf_file')->store('partitions/pdf', 'public');

        // 3. Création en base de données
        // On doit mapper les chemins de fichiers vers les noms de colonnes de la migration
        $partition = Partition::create([
            'title' => $validated['title'],
            'composer' => $validated['composer'],
            'genre' => $validated['genre'],
            'description' => $validated['description'],
            'musicxml_file_path' => $xmlPath,
            'musicpdf_file_path' => $pdfPath,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('partitions.show', $partition)
            ->with('success', 'Partition créée avec succès !');
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
