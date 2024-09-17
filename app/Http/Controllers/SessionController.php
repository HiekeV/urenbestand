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
            dd('hey');

            return redirect('/')->with('success', 'Je bent ingelogd!');
        } 

        throw ValidationException::withMessages([
            'name' => 'Deze inloggegevens zijn onbekend.']);

    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Tot ziens!');
    }
}