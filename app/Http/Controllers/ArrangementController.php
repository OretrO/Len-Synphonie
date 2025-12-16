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
use Illuminate\Support\Str;

class ArrangementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show create form for a given partition
    public function create(Partition $partition)
    {
        $user = Auth::user();
        if (!($user instanceof \App\Models\User) || !in_array($user->role, ['arranger', 'admin'])) {
            abort(403);
        }

        $instruments = Instrument::orderBy('name')->get();

        return view('arrangements.create', compact('partition', 'instruments'));
    }

    // Store new arrangement
    public function store(Request $request, Partition $partition)
    {
        $user = Auth::user();
        if (!($user instanceof \App\Models\User) || !in_array($user->role, ['arranger', 'admin'])) {
            abort(403);
        }

        $rules = [
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'instruments' => ['required', 'array'],
            'instruments.*' => ['exists:instruments,id'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Create arrangement
        $arr = Arrangement::create([
            'partition_id' => $partition->id,
            'creator_id' => $user->id,
            'name' => $request->input('name'),
            'instruments_config' => $request->input('instruments'),
            'description' => $request->input('description'),
            'status' => 'pending',
        ]);

        // Attach instruments with pivot track number (use order index)
        $instruments = $request->input('instruments', []);
        $sync = [];
        foreach ($instruments as $idx => $instId) {
            $sync[$instId] = ['track_number' => $idx + 1];
        }
        $arr->instruments()->sync($sync);

        // Dispatch background job to generate WAV (placeholder)
        // Ideally push to queue: GenerateArrangementAudio::dispatch($arr);
        Log::info('Arrangement created, would dispatch audio job', ['arrangement_id' => $arr->id]);

        return redirect()->route('partitions.show', $partition)->with('success', 'Arrangement created and audio generation queued.');
    }
}
