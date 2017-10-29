<?php

namespace App\Http\Controllers;

use App\Day;
use App\Http\Requests\EmployeeAddWorkDayRequest;
use App\Http\Requests\EmployeeWorkDayRequest;
use App\Slot;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EmployeeController extends Controller
{
    public function index(EmployeeWorkDayRequest $employeeWorkDayRequest)
    {
        // Data od której zaczynamy listing
        if($employeeWorkDayRequest->has('current​​_date')) {
            $currentDay = Carbon::createFromFormat('d.m.Y', $employeeWorkDayRequest->get('current​​_date'));
        } else {
            $currentDay = Carbon::now();
        }

        // Ilość listowanych dni
        $n = $employeeWorkDayRequest->get('n', 4);

        // Dane o slotach i dniach
        /** @var Collection $days */
        $days = Day::with(['slots'])->whereHas('slots')->get()->keyBy('name');

        // Jeśli nie ma żadnych slotów zwracamy pusty wynik
        if($days->isEmpty()) {
            return response()->json([]);
        }

        // Wynik
        $result = collect();

        do {
            $currentDayL = $currentDay->format('l');

            // Jeśli dany dzień tygodnia nie istnieje, przechodzimy do koljenego
            if(! $days->has($currentDayL)) {
                $currentDay->addDay();

                continue;
            }

            /** @var Collection $slotsForCurrentDay */
            $slotsForCurrentDay = $days->get($currentDayL)->slots;

            $result->push([
                'data'  => $currentDay->format('d.m.Y'),
                'slots' => $slotsForCurrentDay->map(function (Slot $slot) {
                    return $slot->getPrettyHours();
                })->toArray(),
            ]);

            $currentDay->addDay();
        } while($result->count() < $n);

        return response()->json($result);
    }

    public function store(EmployeeAddWorkDayRequest $employeeAddWorkDayRequest) {
        foreach($employeeAddWorkDayRequest->all() as $slotsData) {
            Slot::create(array_only($slotsData, ['start', 'end', 'user_id', 'day_id',]));
        }

        return response()->json(['success' => true], 201);
    }
}
