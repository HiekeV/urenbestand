<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('session.create');
    }


    public function store(LoginRequest $request)
    {
        $validated = $request->validated();
        
        if (Auth::attempt($validated))
        {
            return redirect()->route('time-entries.create');
            
        } 

        throw ValidationException::withMessages([
            'email' => 'Deze inloggegevens zijn onbekend.']);

    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}