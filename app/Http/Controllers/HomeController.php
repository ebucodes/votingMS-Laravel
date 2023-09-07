<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('welcome');
    }

    public function liveResults()
    {
        $elections = Election::with('candidates')->get();
        foreach ($elections as $election) {
            $totalVotes = $election->votes->count();

            foreach ($election->candidates as $candidate) {
                $votesForCandidate = $candidate->votes->count();

                if ($totalVotes > 0) {
                    $percentage = ($votesForCandidate / $totalVotes) * 100;
                    $candidate->percentage = round($percentage, 2);
                } else {
                    $candidate->percentage = 0;
                }
            }
        }
        return view('live-results', compact('elections'));
    }
}
