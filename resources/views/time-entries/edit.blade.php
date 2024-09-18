@extends('layouts.app')

@section('content')
    
    <a href="{{ route('time-entries.download') }}">Download de bewerkte CSV</a><br>

    <a href="{{ route('time-entries.destroy-entries') }}">Verwijder alle gegevens</a><br>

    <a href="{{ route('time-entries.create') }}">Upload een nieuwe CSV</a>

    
    <h1>Urenbestand bewerken</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Boekjaar</th>
                <th>Week</th>
                <th>Datum</th>
                <th>Personeelsnummer</th>
                <th>Uren</th>
                <th>Uurcode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timeEntries as $timeEntry)
            <tr>
                <form action="{{ route('time-entries.update', $timeEntry) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <td>{{ $timeEntry->custom_id }}</td>
                    <td><input type="number" name="financial_year" value="{{ $timeEntry->financial_year }}"></td>
                    <td><input type="number" name="week" value="{{ $timeEntry->week }}"></td>
                    <td><input type="date" name="date" value="{{ $timeEntry->date }}"></td>
                    <td><input type="number" name="employee_number" value="{{ $timeEntry->employee_number }}"></td>
                    <td><input type="number" name="hours" step=".01" value="{{ $timeEntry->hours }}"></td>
                    <td><input type="text" name="hour_code" value="{{ $timeEntry->hour_code }}"></td>
                    <td><button type="submit">Update</button></td>
                </form>
                <form action="{{ route('time-entries.destroy', $timeEntry) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <td><button type="submit">Verwijder</button></td>
                </form>
            </tr>
            @endforeach
        </tbody>
        
    </table>

@endsection