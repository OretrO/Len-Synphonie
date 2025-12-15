<?php

namespace App\Http\Controllers;

use App\Models\Partition;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $partitions = Partition::inRandomOrder()->limit(6)->get();

        return view('welcome', [
            'partitions' => $partitions,
        ]);
    }
}
