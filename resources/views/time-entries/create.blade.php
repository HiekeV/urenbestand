@extends('layouts.app')

@section('content')

<form action="{{ route('time-entries.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    CSV-bestand: <br>
    <input type="file" name="csv_file" accept=".csv"><br>
    @error('csv_file')
        <p>{{ $message }}</p>
    @enderror
    
    <p>NB: bij uploaden worden enventueel bestaande gegevens verwijderd.</p> 
    <br>

    <input type="submit" value="uploaden">
</form>

@endsection