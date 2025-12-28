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
        } catch (ValidationException $e) {
            Log::info("Error in AddWeekend: " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            Log::info("Error in AddWeekend: " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetWeekends()
    {
        try {
            $Weekends = WeeklyHoliday::pluck('day')->toArray();
            $Days = array_keys(array_intersect(config('WeeklyHoliday.days'), $Weekends));
            return response()->json(['Days' => $Days]);
        } catch (Exception $e) {
            Log::info("Error in GetWeekends from WeeklyHolidayController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function RemoveWeekends(Request $request)
    {
        try {
            $Validation = $request->validate(['day' => 'required|numeric|between:1,7|exists:weekly_holidays,day']);

            WeeklyHoliday::where('day', $Validation['day'])->delete();

            return response()->json(['success' => array_search($Validation['day'], config('WeeklyHoliday.days')) . " is no longer Weekly Holiday."]);
        } catch (ValidationException $e) {
            Log::info("Error in RemoveWeekends: " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            Log::info("Error in RemoveWeekends: " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
