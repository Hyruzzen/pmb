<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user && ($user->role ?? 'user') === 'admin') {
            return redirect()->route('admin.pendaftaran.index');
        }

        return view('dashboard');
        
    }
    public function dashboard()
{
    $user = auth()->user();
    return view('dashboard', compact('user'));
}
}
