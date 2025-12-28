<?php

namespace App\Http\Controllers;

use App\Models\WeeklyHoliday;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class WeeklyHolidayController extends Controller
{
    public function AddWeekend(Request $request)
    {
        try {
            Gate::authorize('MaximumHolidaysRestriction');

            $Validation = $request->validate(['day' => 'required|numeric|between:1,7|unique:weekly_holidays,day']);

            WeeklyHoliday::create($Validation);

            return response()->json(['success' => 'Weekend added successfully']);
        } catch (Exception $e) {
            Log::info("Error in AddWeekend: " . $e);
            return response()->json(['error' => $e->getMessage()]);
        } catch (ValidationException $e) {
            Log::info("Error in AddWeekend: " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
