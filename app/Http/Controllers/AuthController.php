<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.create');
    }

    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();
                
        $user = User::create($validated);

        return redirect('/')->with('success', 'Je account is aangemaakt.');
    }
}
