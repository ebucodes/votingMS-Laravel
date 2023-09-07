<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SweetAlertHelper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // protected $redirectTo = RouteServiceProvider::HOME;
    // protected $redirectTo = '/login';
    protected $redirectTo = '/voter/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'voter') {
            if ($user->has_voted === 0) {
                SweetAlertHelper::showAlert('Success', 'Successful!', 'success');
                return redirect()->route('voter.dashboard');
            } else {
                SweetAlertHelper::showAlert('Error', 'This user has already voted', 'error');
                // Auth::logout();
                return redirect()->route('live-results');
            }
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }
}
