<?php

namespace App\Http\Controllers;

use App\Models\Partition;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec un échantillon de partitions.
     */
    public function index(): View
    {
        $partitions = Partition::inRandomOrder()->limit(6)->get();

        return view('home', [
            'partitions' => $partitions,
        ]);
    }
}
