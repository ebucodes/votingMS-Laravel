<?php

namespace App\Http\Controllers\Voter;

use App\Helpers\SweetAlertHelper;
use App\Http\Controllers\Controller;
use App\Mail\SuperVoteCastMail;
use App\Mail\VoteCastMail;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VoterController extends Controller
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

    public function dashboard()
    {
        $user = Auth::user();
        //$openElections = Election::where('status', 'open')->with('candidates')->get();
        $livePolls = Election::where('status', 'open')->get();
        // return view('voter.dashboard', compact('livePolls', 'user'));

        if ($user->has_voted === 0) {
            SweetAlertHelper::showAlert('Success', 'Welcome', 'success');
            //return redirect()->route('voter.dashboard');
            return view('voter.dashboard', compact('livePolls', 'user'));
        } else {
            Auth::logout();
            SweetAlertHelper::showAlert('Error', 'You have already voted.', 'error');
            return redirect()->route('live-results')->withInput();
            // return redirect()->back()->withInput();
            // return view('welcome');
        }
    }

    //
    public function submitVote(Request $request)
    {
        $user = Auth::user();
        $votes = $request->input('votes');

        // Initialize a variable to track the success of vote processing
        $success = true;

        // Loop through the submitted votes and save them to the database
        foreach ($votes as $electionId => $candidateId) {
            $vote = new Vote();
            $vote->voter_id = $user->id;
            $vote->election_id = $electionId;
            $vote->candidate_id = $candidateId;
            $save = $vote->save();

            // Check if saving the vote was unsuccessful
            if (!$save) {
                $success = false;
                break; // Exit the loop if any vote fails to save
            }
        }

        if ($success) {
            // Update the user's has_voted status
            $updateStatus = User::where('id', $user->id)->update(['has_voted' => true]);

            if ($updateStatus) {

                $admins = User::where('permission', 'super')->get();
                // Send email notification to supers
                foreach ($admins as $admin) {
                    if ($admin->permission === 'super') {
                        // Mail
                        $super = ([
                            'name' => $admin->name,
                            'voter' => $user->name,
                            'voterID' => $user->voterID,
                            'added' => Carbon::parse($vote->created_at)->format('F dS, Y -
                                                h:i
                                                A')
                        ]);
                        Mail::to($admin->email)->send(new SuperVoteCastMail($super));
                    }
                }
                // send email notification to voter
                $info = ([
                    'name' => $user->name,
                ]);
                Mail::to($user->email)->send(new VoteCastMail($info));
                SweetAlertHelper::showAlert('Success', 'Votes submitted successfully!', 'success');
                //return back()->with('success', 'Successful');
                //Auth::logout();
                return redirect()->route('live-results');
            } else {
                // return back()->with('fail', 'Error');
                SweetAlertHelper::showAlert('Error', 'Failed to update user status.', 'error');
            }
        } else {
            return back()->with('fail', 'Error');
            SweetAlertHelper::showAlert('Error', 'Failed to save votes.', 'error');
        }

        return redirect()->back()->withInput();
    }

    //
    public function liveResults()
    {
        $elections = Election::with('candidates')->get();

        return view('live-results', compact('elections'));
    }
}
