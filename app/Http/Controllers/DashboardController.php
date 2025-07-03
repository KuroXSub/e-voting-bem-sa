<?php

namespace App\Http\Controllers;

use App\Models\ElectionPeriod;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activePeriod = ElectionPeriod::where('status', '!=', 'Non-aktif')->first();
        
        $userVoted = false;
        $periodStatus = 'Non-aktif';
        $periodData = null;

        if ($activePeriod) {
            $periodStatus = $activePeriod->status;
            $periodData = [
                'name' => $activePeriod->name,
                'start_date' => $activePeriod->start_date->format('H:i | d M Y'),
                'end_date' => $activePeriod->end_date->format('H:i | d M Y'),
                'id' => $activePeriod->id,
            ];

            if ($periodStatus === 'Sedang Berlangsung') {
                $userVoted = Vote::where('voter_id', $user->id)
                    ->where('election_period_id', $activePeriod->id)
                    ->exists();
            }
        }

        return view('dashboard', [
            'user' => $user,
            'periodStatus' => $periodStatus,
            'periodData' => $periodData,
            'userVoted' => $userVoted,
            'activePeriod' => $activePeriod,
        ]);
    }
}