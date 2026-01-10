<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;

class ProdiController extends Controller
{
    public function index()
    {
        return response()->json(
            ProgramStudi::with('fakultas')->get()
        );
    }
}

