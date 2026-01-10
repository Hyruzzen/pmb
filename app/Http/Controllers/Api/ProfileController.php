<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $user->update($request->only([
            'name', 'no_hp'
        ]));

        return response()->json([
            'message' => 'Profile updated',
            'user'    => $user
        ]);
    }
}

