@extends('layouts.app')

@section('content')



<form action="{{ route('time-entries.update', $timeEntries) }}" method="POST">
    @method('PUT')
    @csrf
    
    <table>
    @foreach ($timeEntries as $timeEntry)
        <tr>
            <td>{{ $timeEntry->financial_year }}</td>
            <td>{{ $timeEntry->week }}</td>
            <td>{{ $timeEntry->date }}</td>
            <td>{{ $timeEntry->employee_number }}</td>
            <td>{{ $timeEntry->hours }}</td>
            <td>{{ $timeEntry->hour_code }}</td>
            </tr>
    @endforeach
    </table>


</form>



@endsection