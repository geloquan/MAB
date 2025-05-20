<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'username' => 'John Doe',
            'isAdmin' => true,
            'items' => ['Item 1', 'Item 2', 'Item 3'],
        ];

        // Pass data to the view
        return view('home', $data);
    }
}
