<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Voter\VoterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/live-results', 'liveResults')->name('live-results');
});
// Auth::routes();
Auth::routes(['verify' => true]);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::group(['middleware' => ['auth', 'verified']], function () {
//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    // Routes accessible only to Admins
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');
        Route::get('/election/results', 'electionResults')->name('election-results');
        Route::get('/election/download-result', 'downloadResult')->name('download-result');
        Route::get('/election/table', 'resultsTable')->name('table');
    });
    Route::resource('/admin/candidates', CandidateController::class);
    Route::resource('/admin/elections', ElectionController::class);
    //
    Route::controller(UsersController::class)->group(function () {
        Route::get('/admin/users/admins', 'adminIndex')->name('admins.index');
        Route::post('/admin/users/add-admin', 'addAdmin')->name('admin.add');
        Route::post('/admin/update/{id}', 'updateAdmin')->name('admin.update');
        Route::post('/admin/delete/{id}', 'deleteAdmin')->name('admin.delete');
        //
        Route::get('/admin/users/voters', 'votersIndex')->name('voters.index');
    });
});

Route::group(['middleware' => ['auth', 'verified', 'role:voter']], function () {
    // Routes accessible to Voters and Admins
    Route::controller(VoterController::class)->group(function () {
        Route::get('/voter/dashboard', 'dashboard')->name('voter.dashboard');
        Route::post('/voter/submit-vote', 'submitVote')->name('submit.vote');
    });
    //Route::get('/voter/dashboard', 'VoterController@dashboard')->name('voter.dashboard');
    // Route::post('/submit-vote', 'VoterController@submitVote');

});
