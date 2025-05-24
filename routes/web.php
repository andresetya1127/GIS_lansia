<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate')->name('authenticate')->middleware('guest');
    Route::get('/register', 'register')->name('register')->middleware('guest');
    Route::post('/register', 'store')->name('auth.store')->middleware('guest');
    Route::get('/logout', 'logout')->name('logout')->middleware('auth');
});


// Admin Dashboard
Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin', 'controller' => DashboardController::class], function () {
    Route::get('/dashboard', 'index')->name('dashboard')->middleware('can:show dashboard');
    Route::get('/dashboard/locations', 'locations')->middleware('can:show dashboard');
});


// Roles
Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'roles', 'controller' => RoleController::class], function () {
    Route::get('/', 'index')->name('role');
    Route::get('/create', 'create')->name('role.create');
    Route::post('/store', 'store')->name('role.store');
    Route::get('/edit/{id}', 'edit')->name('role.edit');
    Route::post('/update/{id}', 'update')->name('role.update');
    Route::delete('/delete/{id}', 'delete')->name('role.delete');
});

// Users
Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'users', 'controller' => UserController::class], function () {
    Route::get('/', 'index')->name('users')->middleware('can:show users');
    Route::get('/create', 'create')->name('users.create')->middleware('can:create users');
    Route::post('/store', 'store')->name('users.store')->middleware('can:create users');
    Route::get('/edit/{id}', 'edit')->name('users.edit')->middleware('can:edit users');
    Route::post('/update/{id}', 'update')->name('users.update')->middleware('can:edit users');
    Route::delete('/delete/{id}', 'delete')->name('users.delete')->middleware('can:delete users');
});

// Users
Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'lansia', 'controller' => LansiaController::class], function () {
    Route::get('/', 'index')->name('lansia')->middleware('can:show lansia');
    Route::get('/edit/{id}', 'edit')->name('lansia.edit')->middleware('can:create lansia');
    Route::post('/store/{id}', 'store')->name('lansia.store')->middleware('can:create lansia');
    Route::post('/location/check', 'findLocation')->name('lansia.findLocation')->middleware('can:create lansia');
    Route::get('/detail/{id}', 'detailResponse')->name('response.lansia.detail')->middleware('can:show lansia');
    Route::get('/show/{id}', 'detail')->name('lansia.detail')->middleware('can:show lansia');
    Route::post('/import', 'import')->name('lansia.import')->middleware('can:create lansia');
    Route::get('/export', 'export')->name('lansia.export')->middleware('can:create lansia');
});



// Verification
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    try {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', __('Verification link sent!'));
    } catch (\Throwable $th) {
        return back()->with('message', __('failed'));
    }
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/email/verify', function (Request $request) {
    if (!$request->user()->hasVerifiedEmail()) {
        return view('pages.lansia.verify.email-verification');
    }
    return redirect()->route('dashboard');
})->middleware('auth')->name('verification.notice');
