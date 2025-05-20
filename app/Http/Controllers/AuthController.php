<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    public function fakeLogin(Request $request)
    {
        // Get the first user from the database or create a fake user
        session(['is_admin' => true]);

        return redirect()->route('admin.dashboard');
    }
}