<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SweetAlertHelper;
use App\Http\Controllers\Controller;
use App\Mail\NewCandidateMail;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $page_title = 'Candidates';
        $candidates = Candidate::all();
        $count = Candidate::count();
        $positions = Election::where('status', 'open')->get();
        return view('admin.candidates', compact('page_title', 'candidates', 'count', 'positions'));
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
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('candidates')->where(function ($query) {
                    // return $query->where('status', 'open');
                }),
            ],
            // Add other validation rules for candidate fields
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            //
            $candidate = new Candidate();
            $candidate->name = $request->name;
            $candidate->election_id = $request->position;
            $candidate->email = $request->email;
            $candidate->sex = $request->sex;
            // //$image = $request->image;
            $image = $request->image; // Access the uploaded file using the file method

            if ($image) {
                $logo_name = 'candidate-' . time() . random_int(1, 1000) . '.' . $image->getClientOriginalExtension();
                $image->move('img/candidates/', $logo_name);
                $candidate->image = $logo_name;
            }
            $create = $candidate->save();

            //
            if ($create) {
                // Mail
                $info = ([
                    'name' => $candidate->name,
                    'position' => $candidate->election_id,
                    'sex' => $candidate->sex,
                    'added' => $candidate->created_at
                ]);
                Mail::to($candidate->email)->send(new NewCandidateMail($info));
                SweetAlertHelper::showAlert('Success', 'Successful!', 'success');
                return redirect()->route('candidates.index');
            } else {
                SweetAlertHelper::showAlert('Error', 'Failed to create the candidate.', 'error');
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
        $candidate = Candidate::find($id);
        $candidate->name = $request->name;
        // $candidate->position = $request->position;
        $candidate->email = $request->email;
        $candidate->sex = $request->sex;
        //$image = $request->image;
        // $image = $request->image; // Access the uploaded file using the file method

        // if ($image) {
        //     $logo_name = 'candidate-' . time() . random_int(1, 1000) . '.' . $image->getClientOriginalExtension();
        //     $image->move('img/candidates/', $logo_name);
        //     $candidate->image = $logo_name;
        // }
        $create = $candidate->save();

        //
        if ($create) {
            SweetAlertHelper::showAlert('Success', 'Successful!', 'success');
            return redirect()->route('candidates.index');
        } else {
            SweetAlertHelper::showAlert('Error', 'Failed to create the candidate.', 'error');
            return redirect()->back()->withInput();
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
        $candidate = Candidate::find($id);
        @unlink('img/candidates/' . $candidate->image);
        $delete = $candidate->delete();

        //
        if ($delete) {
            SweetAlertHelper::showAlert('Success', 'Successfully!', 'success');
            return redirect()->route('candidates.index');
        } else {
            SweetAlertHelper::showAlert('Error', 'Failed to create the election.', 'error');
            return redirect()->back()->withInput();
        }
    }
}
