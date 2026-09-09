<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->usertype === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
