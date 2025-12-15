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
        return view('partitions.index', compact('partitions'));
    }

    public function create()
    {

        return view('partitions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
        ]);

        // Upload du fichier MusicXML
        $path = $request->file('musicxml_file')->store('partitions', 'public');

        $partition = Partition::create([
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partition $partition)
    {

        return view('partitions.edit', compact('partition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partition $partition)
    {

        $validated = $request->validate([
        ]);


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

        $partition->delete();

    }
}

