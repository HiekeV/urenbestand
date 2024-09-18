<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Http\Requests\StoreTimeEntryRequest;
use App\Http\Requests\UpdateTimeEntryRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Storage;

class TimeEntryController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
            // 
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
        TimeEntry::query()->delete();

        $csvFile = $request->file('csv_file');
        
        $csvData = file_get_contents($csvFile->getRealPath());
        
        $rows = explode("\n", $csvData);
        
        array_shift($rows);

        $customId = 1;

        foreach ($rows as $row) {
            $data = str_getcsv($row, ';');

            try {
                $formattedDate = Carbon::createFromFormat('d/m/Y', $data[2])->format('Y-m-d');
            } catch (\Exception $e) {
                continue; 
            }

            $hours = str_replace(',', '.', $data[4]);

            DB::table('time_entries')->insert([
                'custom_id' => $customId,
                'financial_year' => $data[0],
                'week' => $data[1],
                'date' => $formattedDate ,
                'employee_number' => $data[3],
                'hours' => $hours,
                'hour_code' => $data[5],
            ]);
            $customId++;
        }

        $timeEntries = TimeEntry::all();

        return view('time-entries.edit', ['timeEntries' => $timeEntries]);
        
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
        $validated = $request->validated();

        $timeEntry->update($validated);

        return redirect()->back();
    }

    public function download()
    {
        $timeEntries = TimeEntry::all();

        $fileName = 'download.csv';
        
        $filePath = 'csv/' . $fileName;

        $csvContent = fopen('php://temp', 'r+');

        fputcsv($csvContent, ['Boekjaar','Week','Datum','Persnr','Uren','Uurcode']);

        foreach ($timeEntries as $entry) {
            
            $hours = str_replace('.', ',', $entry->hours);

            $formattedDate = Carbon::createFromFormat('Y-m-d', $entry->date)->format('d/m/Y');

            fputcsv($csvContent, [
                $entry->financial_year,
                $entry->week,
                $formattedDate,
                $entry->employee_number,
                $hours,
                $entry->hour_code,
                ], ';');
        }

        rewind($csvContent);

        $csvString = stream_get_contents($csvContent);
        fclose($csvContent);

        Storage::put($filePath, $csvString);

        return Storage::download($filePath, $fileName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeEntry  $timeEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeEntry $timeEntry)
    {
        $timeEntry->delete();

        $timeEntries = TimeEntry::all();

        return view('time-entries.edit', ['timeEntries' => $timeEntries]);
    }

    public function destroyAll()
    {
        TimeEntry::query()->delete();

        return view('time-entries.create');
    }
}
