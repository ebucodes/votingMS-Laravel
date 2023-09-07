<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;
use App\Helpers\SweetAlertHelper;
use App\Mail\NewPollsMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $page_title = 'Polls';
        $elections = Election::all();
        $count = Election::count();
        return view('admin.elections', compact('page_title', 'elections', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $start = Carbon::parse($request->input('start'));
        $end = Carbon::parse($request->input('end'));

        $errors = [];
        // Validate if title already exists
        $existingPoll = Election::where('title', trim($request->title))
            ->where('status', 'open')
            ->first();

        if ($existingPoll) {
            SweetAlertHelper::showAlert('Error', 'This poll already exists.', 'error');
            return redirect()->back()->withInput();
        }
        if ($start->isPast()) {
            $errors[] = 'You cannot set a date earlier than today.';
        }

        if ($end->isBefore($start)) {
            $errors[] = 'End date cannot be earlier than start date.';
        }

        if ($start->isSameDay($end)) {
            $errors[] = 'Start and end date cannot be the same.';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                SweetAlertHelper::showAlert('Error', $error, 'error');
            }
            return redirect()->back()->withInput();
        } else {
            //
            $election = new Election();
            $election->title = $request->title;
            $election->description = $request->description;
            $election->start = $request->start;
            $election->end = $request->end;
            $create = $election->save();

            //
            if ($create) {

                // Mail
                $info = ([
                    'name' => $user->name,
                    'role' => $user->role,
                    'title' => $election->title,
                    'start' => $election->start,
                    'end' => $election->end,
                    'status' => $election->status

                ]);
                // Trigger email notification to users
                $users = User::all(); // Fetch the users to notify
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NewPollsMail($info));
                    // Mail::to($user->email)->send(new NewPollCreated($poll));
                }

                SweetAlertHelper::showAlert('Success', 'Election created successfully!', 'success');
                return redirect()->route('elections.index');
            } else {
                SweetAlertHelper::showAlert('Error', 'Failed to create the election.', 'error');
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $start = Carbon::parse($request->input('start'));
        $end = Carbon::parse($request->input('end'));

        $errors = [];
        if ($start->isPast()) {
            $errors[] = 'You cannot set a date earlier than today.';
        }

        if ($end->isBefore($start)) {
            $errors[] = 'End date cannot be earlier than start date.';
        }

        if ($start->isSameDay($end)) {
            $errors[] = 'Start and end date cannot be the same.';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                SweetAlertHelper::showAlert('Error', $error, 'error');
            }
            return redirect()->back()->withInput();
        } else {
            //
            $election = Election::find($id);
            $election->title = $request->title;
            $election->description = $request->description;
            $election->start = $request->start;
            $election->end = $request->end;
            $election->status = $request->status;
            $create = $election->save();

            //
            if ($create) {
                SweetAlertHelper::showAlert('Success', 'Successfully!', 'success');
                return redirect()->route('elections.index');
            } else {
                SweetAlertHelper::showAlert('Error', 'Failed to create the election.', 'error');
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $election = Election::find($id);
        $delete = $election->delete();

        //
        if ($delete) {
            SweetAlertHelper::showAlert('Success', 'Successfully!', 'success');
            return redirect()->route('elections.index');
        } else {
            SweetAlertHelper::showAlert('Error', 'Failed to create the election.', 'error');
            return redirect()->back()->withInput();
        }
    }
}
