<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::with(['posts' => function ($query) {
            $query->withCount(['likes', 'dislikes', 'comments']);
        }])->findOrFail($id);

        return view('userView', compact('user'));
    }
}
