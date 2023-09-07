<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SweetAlertHelper;
use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PDF;


class AdminController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    //
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    //
    // public function electionResults()
    // {
    //     $page_title = 'Results';
    //     // Retrieve the elections with their candidates
    //     $elections = Election::with('candidates')->get();

    //     // Calculate the results for each election
    //     $results = [];
    //     foreach ($elections as $election) {
    //         $candidates = $election->candidates;
    //         $results[$election->id] = [
    //             'title' => $election->title,
    //             'results' => [],
    //         ];

    //         // Count the votes for each candidate
    //         foreach ($candidates as $candidate) {
    //             $votes = $candidate->votes->count();
    //             $results[$election->id]['results'][] = [
    //                 'name' => $candidate->name,
    //                 'votes' => $votes,
    //             ];
    //         }
    //     }
    //     return view('admin.results', compact('page_title', 'results', 'elections'));
    // }

    public function electionResults()
    {
        $page_title = 'Results';

        $count = User::where('role', 'voter')->where('has_voted', 1)->count();
        // Retrieve the elections with their candidates
        $elections = Election::with('candidates')->get();

        // Calculate the results for each election
        $results = [];
        foreach ($elections as $election) {
            $candidates = $election->candidates;
            $results[$election->id] = [
                'title' => $election->title,
                'results' => [],
            ];

            // Count the votes for each candidate
            $votesCount = $candidates->flatMap(function ($candidate) {
                return $candidate->votes;
            })->groupBy('candidate_id')->map->count();

            // Sort the candidates based on the vote count
            $sortedCandidates = $candidates->sort(function ($a, $b) use ($votesCount) {
                return $votesCount->get($b->id, 0) <=> $votesCount->get($a->id, 0);
            });

            // Prepare the results with sorted candidates
            foreach ($sortedCandidates as $candidate) {
                $votes = $votesCount->get($candidate->id, 0);
                $results[$election->id]['results'][] = [
                    'name' => $candidate->name,
                    'votes' => $votes,
                ];
            }
        }

        return view('admin.results', compact('page_title', 'results', 'elections', 'count'));
    }

    //
    public function resultsTable()
    {
        $page_title = 'Results';

        $count = User::where('role', 'voter')->where('has_voted', 1)->count();
        // Retrieve the elections with their candidates
        $elections = Election::with('candidates')->get();

        // Calculate the results for each election
        $results = [];
        foreach ($elections as $election) {
            $candidates = $election->candidates;
            $results[$election->id] = [
                'title' => $election->title,
                'results' => [],
            ];

            // Count the votes for each candidate
            $votesCount = $candidates->flatMap(function ($candidate) {
                return $candidate->votes;
            })->groupBy('candidate_id')->map->count();

            // Sort the candidates based on the vote count
            $sortedCandidates = $candidates->sort(function ($a, $b) use ($votesCount) {
                return $votesCount->get($b->id, 0) <=> $votesCount->get($a->id, 0);
            });

            // Prepare the results with sorted candidates
            foreach ($sortedCandidates as $candidate) {
                $votes = $votesCount->get($candidate->id, 0);
                $results[$election->id]['results'][] = [
                    'name' => $candidate->name,
                    'votes' => $votes,
                ];
            }
        }

        return view('admin.results_table', compact('page_title', 'results', 'elections', 'count'));
    }

    public function downloadResult()
    {

        // Retrieve the elections with their candidates
        $elections = Election::with('candidates')->get();

        // Calculate the results for each election
        $results = [];
        foreach ($elections as $election) {
            $candidates = $election->candidates;
            $results[$election->id] = [
                'title' => $election->title,
                'results' => [],
            ];

            // Count the votes for each candidate
            $votesCount = $candidates->flatMap(function ($candidate) {
                return $candidate->votes;
            })->groupBy('candidate_id')->map->count();

            // Sort the candidates based on the vote count
            $sortedCandidates = $candidates->sort(function ($a, $b) use ($votesCount) {
                return $votesCount->get($b->id, 0) <=> $votesCount->get($a->id, 0);
            });

            // Prepare the results with sorted candidates
            foreach ($sortedCandidates as $candidate) {
                $votes = $votesCount->get($candidate->id, 0);
                $results[$election->id]['results'][] = [
                    'name' => $candidate->name,
                    'votes' => $votes,
                ];
            }
        }

        // Generate the PDF content
        $tableHtml = view('admin.results_table', compact('results'))->render();
        // Generate the PDF content
        $pdf = PDF::loadHTML($tableHtml);
        // Download the PDF file
        return $pdf->download('results.pdf');
        SweetAlertHelper::showAlert('Success', 'Successful!', 'success');
        return back();
    }
}
