@extends('layouts.app')

@section('content')

<h1>Inloggen</h1>

<form action="{{ route('session.store') }}" method="POST">
    @csrf

    Naam: <br>
    <input type="text" name="name" value="{{ old('name') }}"><br>
    @error('name')
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