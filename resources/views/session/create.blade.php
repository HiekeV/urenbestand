@extends('layouts.app')

@section('content')

<h1>Inloggen</h1>

<form action="{{ route('session.store') }}" method="POST">
    @csrf

    E-mail: <br>
    <input type="text" name="email" value="{{ old('email') }}"><br>
    @error('email')
        <p>{{ $message }}</p>
    @enderror
    
    Wachtwoord: <br>
    <input type="password" name="password"><br>
    @error('password')
        <p>{{ $message }}</p>
    @enderror
    <br>
    <input type="submit" value="inloggen">
</form>

@endsection