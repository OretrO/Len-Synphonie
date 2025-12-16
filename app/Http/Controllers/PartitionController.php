<?php

namespace App\Http\Controllers;

use App\Models\Partition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            ->with('success', 'Score created successfully.');
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
        $this->authorize('update', $partition);

        $validated = $request->validate([
            'title' => 'required|string|min:5|max:50',
            'composer' => 'required|string|min:5|max:50',
            'genre' => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
            'musicxml_file' => 'nullable|file|extensions:xml,musicxml|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Update basic fields
        $partition->title = $validated['title'];
        $partition->composer = $validated['composer'];
        $partition->genre = $validated['genre'];
        $partition->description = $validated['description'] ?? null;

        // 🔴 CRITICAL: If MusicXML is updated, delete all associated arrangements
        if ($request->hasFile('musicxml_file')) {
            // Delete all arrangements because the XML file has changed
            $partition->arrangements()->delete();

            $path = $request->file('musicxml_file')->store('partitions/xml', 'public');
            $partition->musicxml_file_path = $path;
        }

        // Update PDF if provided
        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('partitions/pdf', 'public');
            $partition->musicpdf_file_path = $path;
        }

        $partition->save();

        return redirect()->route('partitions.show', $partition)
            ->with('success', 'Score updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * A partition can only be deleted if it has no associated arrangements.
     */
    public function destroy(Partition $partition)
    {
        $this->authorize('delete', $partition);

        // 🔴 CRITICAL: Check if partition has arrangements
        if ($partition->arrangements()->count() > 0) {
            return back()->withErrors([
                'delete' => 'Cannot delete a score with existing arrangements. Delete all arrangements first.',
            ])->with('error', 'Cannot delete a score with existing arrangements.');
        }

        $partition->delete();

        return redirect()->route('partitions.index')
            ->with('success', 'Score deleted successfully.');
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
    /**
     * Get the arrangements for the partition.
     */
    public function arrangements()
    {
        return $this->hasMany(Arrangement::class);
    }

    /**
     * Download the associated file (PDF or XML).
     */
    public function downloadFile(Partition $partition, string $type)
    {
        $this->authorize('view', $partition);

        if ($type === 'pdf') {
            $path = $partition->musicpdf_file_path;
            if (!$path || !Storage::disk('public')->exists($path)) {
                abort(404, 'PDF file not found.');
            }
            return Storage::disk('public')->response($path);
        } elseif ($type === 'xml') {
            $path = $partition->musicxml_file_path;
            if (!$path || !Storage::disk('public')->exists($path)) {
                abort(404, 'XML file not found.');
            }
            return Storage::disk('public')->download($path);
        }

        abort(404);
    }
}
