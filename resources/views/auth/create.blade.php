@extends('layouts.app')

@section('content')

<h1>Registreren</h1>

<form action="/register" method="POST">
    @csrf

    Naam: <br>
    <input type="text" name="name" value="{{ old('name') }}"><br>
    @error('name')
        <p>{{ $message }}</p>
    @enderror

    Emailadres: <br>
    <input type="email" name="email" value="{{ old('email') }}"><br>
    @error('email')
        <p>{{ $message }}</p>
    @enderror
    
    Wachtwoord: <br>
    <input type="password" name="password"><br>
    @error('password')
        <p>{{ $message }}</p>
    @enderror

    <br>
    <input type="submit" value="registreren">
</form>

@endsection