<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\ElectionPeriod;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $activePeriod = ElectionPeriod::where('status', 'Sedang Berlangsung')->first();

        // Jika request modal (ajax)
        if ($request->ajax()) {
            if (!$activePeriod) {
                return response()->json([
                    'html' => view('election.modals.no-election-modal')->render()
                ]);
            }

            $candidates = Candidate::where('election_period_id', $activePeriod->id)
                ->orderBy('number')
                ->get();

            return response()->json([
                'html' => view('election.modals.candidate-list-modal', [
                    'candidates' => $candidates
                ])->render()
            ]);
        }

        if (!$activePeriod) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pemilihan yang sedang berlangsung');
        }

        $userVoted = Vote::where('voter_id', $user->id)
            ->where('election_period_id', $activePeriod->id)
            ->exists();

        $candidates = Candidate::where('election_period_id', $activePeriod->id)
            ->orderBy('number')
            ->get();

        return view('election.index', [
            'user' => $user,
            'activePeriod' => $activePeriod,
            'userVoted' => $userVoted,
            'candidates' => $candidates,
        ]);
    }

    public function showCandidateDetail(Candidate $candidate)
    {
        try {
            // Validasi akses
            $this->validateCandidateAccess($candidate);
            
            return response()->json([
                'html' => view('election.modals.candidate-detail', [
                    'candidate' => $candidate->load(['chairman', 'viceChairman'])
                ])->render()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmVote(Candidate $candidate)
    {
        try {
            $user = Auth::user();
            $activePeriod = ElectionPeriod::where('status', 'Sedang Berlangsung')->first();

            // Validasi
            $this->validateActivePeriod($activePeriod);
            $this->validateUserVote($user, $activePeriod);
            $this->validateCandidatePeriod($candidate, $activePeriod);

            return response()->json([
                'html' => view('election.modals.confirm-vote', [
                    'candidate' => $candidate
                ])->render()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function submitVote(Request $request, Candidate $candidate)
    {
        try {
            $user = Auth::user();
            $activePeriod = ElectionPeriod::where('status', 'Sedang Berlangsung')->first();

            // Validasi
            $this->validateActivePeriod($activePeriod);
            $this->validateUserVote($user, $activePeriod);
            $this->validateCandidatePeriod($candidate, $activePeriod);

            // Simpan vote
            Vote::create([
                'election_period_id' => $activePeriod->id,
                'voter_id' => $user->id,
                'candidate_id' => $candidate->id,
            ]);

            return response()->json([
                'success' => true,
                'html' => view('election.modals.thank-you')->render(),
                'redirect_url' => route('dashboard')
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function validateActivePeriod($activePeriod)
    {
        if (!$activePeriod) {
            throw new \Exception('Tidak ada pemilihan aktif');
        }
    }

    private function validateUserVote($user, $activePeriod)
    {
        if (Vote::where('voter_id', $user->id)
            ->where('election_period_id', $activePeriod->id)
            ->exists()) {
            throw new \Exception('Anda sudah memilih');
        }
    }

    private function validateCandidatePeriod($candidate, $activePeriod)
    {
        if ($candidate->election_period_id !== $activePeriod->id) {
            throw new \Exception('Kandidat tidak valid untuk periode ini');
        }
    }

    private function validateCandidateAccess($candidate)
    {
        $activePeriod = ElectionPeriod::where('status', 'Sedang Berlangsung')->first();
        if (!$activePeriod || $candidate->election_period_id !== $activePeriod->id) {
            throw new \Exception('Tidak dapat mengakses kandidat ini');
        }
    }
}