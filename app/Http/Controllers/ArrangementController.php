<?php

namespace App\Http\Controllers;

use App\Models\Arrangement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // 1. Vérification des droits via la Policy
        $this->authorize('delete', $arrangement);

        // 2. Nettoyage du fichier audio s'il existe (éviter les fichiers orphelins)
        if ($arrangement->audio_file_path && Storage::disk('public')->exists($arrangement->audio_file_path)) {
            Storage::disk('public')->delete($arrangement->audio_file_path);
        }

        // 3. Sauvegarder l'ID de la partition pour la redirection
        $partitionId = $arrangement->partition_id;

        // 4. Suppression en base de données
        $arrangement->delete();

        // 5. Redirection vers la page de la partition (plus logique que l'index des arrangements)
        return redirect()->route('partitions.show', $partitionId)
            ->with('success', 'Arrangement supprimé avec succès.');
    }
}
