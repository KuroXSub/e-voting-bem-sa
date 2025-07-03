<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\ElectionPeriod;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $activePeriod = ElectionPeriod::where('status', 'Sedang Berlangsung')->first();
        $candidates = $activePeriod ? Candidate::where('election_period_id', $activePeriod->id)
            ->with(['chairman', 'viceChairman'])
            ->orderBy('number')
            ->get() : collect();

        return view('welcome.index', [
            'activePeriod' => $activePeriod,
            'candidates' => $candidates
        ]);
    }
}