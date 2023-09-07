<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SweetAlertHelper;
use App\Http\Controllers\Controller;
use App\Mail\NewAdminMail;
use App\Mail\SuperAdminMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    //

    public function adminIndex()
    {
        $user = Auth::user();
        $permission = $user->permission;
        $page_title = 'Admins';
        $admins = User::where('role', 'admin')->get();
        $count = User::where('role', 'admin')->count();
        return view('admin.admins', compact('permission', 'user', 'page_title', 'admins', 'count'));
    }

    //
    public function addAdmin(Request $request)
    {
        $user = Auth::user();
        //
        $checkEmail = User::where('email', $request->email)->first();
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => [
        //         'required',
        //         'email',
        //         Rule::unique('candidates')->where(function ($query) {
        //             // return $query->where('status', 'open');
        //         }),
        //     ],
        //     // Add other validation rules for candidate fields
        // ]);

        if ($checkEmail) {
            SweetAlertHelper::showAlert('Error', 'Email address already exists.', 'error');
            return redirect()->back()->withInput();
        } else {
            $date = Carbon::now();

            $admins = new User();
            $admins->name = $request->name;
            $admins->email = $request->email;
            $admins->permission = $request->permission;
            $admins->email_verified_at = $date;
            $admins->role = 'admin';
            $admins->password = Hash::make($request->password);
            $create = $admins->save();
            //
            if ($create) {
                $adminsPermissions = User::where('role', 'admin')->get();
                foreach ($adminsPermissions as $permission) {
                    if ($permission->permission === 'super') {
                        // Mail
                        $super = ([
                            'name' => $permission->name,
                            'new_admin' => $admins->name,
                            'permission' => $admins->permission,
                            'by' => $user->name,
                            'added' => $admins->created_at
                        ]);
                        Mail::to($permission->email)->send(new SuperAdminMail($super));
                    }
                }
                //
                $info = ([
                    'name' => $admins->name,
                    'email' => $admins->email,
                    'permission' => $admins->permission,
                    'password' => $request->password,
                    'added' => $admins->created_at
                ]);
                Mail::to($admins->email)->send(new NewAdminMail($info));
                SweetAlertHelper::showAlert('Success', 'Successful!', 'success');
                return redirect()->route('admins.index');
            } else {
                SweetAlertHelper::showAlert('Error', 'Failed to create the admin.', 'error');
                return redirect()->back()->withInput();
            }
        }
    }

    //
    public function updateAdmin(Request $request, $id)
    {
        $admins = User::find($id);
        $admins->name = $request->name;
        $admins->email = $request->email;
        $admins->permission = $request->permission;
        $update = $admins->save();
        //
        if ($update) {
            SweetAlertHelper::showAlert('Success', 'Successful!', 'success');
            return redirect()->route('admins.index');
        } else {
            SweetAlertHelper::showAlert('Error', 'Failed to create the admin.', 'error');
            return redirect()->back()->withInput();
        }
    }

    //
    public function deleteAdmin($id)
    {
        //
        $admins = User::find($id);
        $delete = $admins->delete();
        if ($delete) {
            SweetAlertHelper::showAlert('Success', 'Successful!', 'success');
            return redirect()->route('admins.index');
        } else {
            SweetAlertHelper::showAlert('Error', 'Failed to delete.', 'error');
            return redirect()->back()->withInput();
        }
    }

    //
    public function votersIndex()
    {
        $user = Auth::user();
        $page_title = 'Voters';
        $voters = User::where('role', 'voter')->get();
        $count = User::where('role', 'voter')->count();
        return view('admin.voters', compact('voters', 'page_title', 'count'));
    }
}