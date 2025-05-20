<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
  return view('home');
})->name('home');

Route::get('/login', function () {
  if (Auth::check()) {
    return redirect()->route('admin.dashboard');
  }
  return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Request $request) {
  $credentials = $request->only('username', 'password');

  $return = DB::select('SELECT login(?, ?)', [
    $request->username,
    $request->password
  ]);

  if ($return[0]) {
    Auth::loginUsingId($return[0]->login);

    return redirect()->intended(route('admin.dashboard'));
  }

  return back()->withErrors(['login' => 'Invalid credentials']);
});


Route::get('/admin', [AdminController::class, 'render'])->name('admin.dashboard')->middleware('auth');
Route::get('/client', [ClientController::class, 'render'])->name('client');
