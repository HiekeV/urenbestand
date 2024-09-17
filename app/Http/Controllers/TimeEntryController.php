<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Http\Requests\StoreTimeEntryRequest;
use App\Http\Requests\UpdateTimeEntryRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimeEntryController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('time-entries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTimeEntryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeEntryRequest $request)
    {
        $csvFile = $request->file('csv_file');
        
        // Open the CSV file
        $csvData = file_get_contents($csvFile->getRealPath());
        
        // Split the CSV data into rows
        $rows = explode("\n", $csvData);
        
        // Skip the header row
        array_shift($rows);

        // Insert the data into the database
        foreach ($rows as $row) {
            $data = str_getcsv($row, ';');

            // Ensure the row has at least 5 columns
            if (count($data) < 5) {
                // Optionally log or handle the error here
                continue; // Skip this row
            }
                    // Convert date from dd/mm/yyyy to yyyy-mm-dd
            try {
                $formattedDate = Carbon::createFromFormat('d/m/Y', $data[2])->format('Y-m-d');
            } catch (\Exception $e) {
                // Handle invalid date format if necessary
                continue; // Skip this row if the date is invalid
            }

            // Replace comma with dot for hours, to handle European-style decimals
            $hours = str_replace(',', '.', $data[4]);

            DB::table('time_entries')->insert([
                'financial_year' => $data[0],
                'week' => $data[1],
                'date' => $formattedDate,
                'employee_number' => $data[3],
                'hours' => $hours,  // Corrected hours
                'hour_code' => $data[5],
            ]);
        }

        return redirect()->route('time-entries.edit')->with('success', 'CSV file imported successfully.');
    }


//     /**
//      * Display the specified resource.
//      *
//      * @param  \App\Models\TimeEntry  $timeEntry
//      * @return \Illuminate\Http\Response
//      */
//     public function show(TimeEntry $timeEntry)
//     {
//         //
//     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeEntry  $timeEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeEntry $timeEntry)
    {
        $timeEntries = TimeEntry::all();

        return view('time-entries.edit',['timeEntries' => $timeEntries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTimeEntryRequest  $request
     * @param  \App\Models\TimeEntry  $timeEntry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimeEntryRequest $request, TimeEntry $timeEntry)
    {
        //
    }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  \App\Models\TimeEntry  $timeEntry
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy(TimeEntry $timeEntry)
//     {
//         //
//     }
}
