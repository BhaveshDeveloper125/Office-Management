<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class HolidayController extends Controller
{
    public function AddHoliday(Request $request)
    {
        try {
            $Validation = $request->validate([
                'from' => 'required|date|before_or_equal:to',
                'to'   => 'required|date|after_or_equal:from',
                'title' => 'required|string|max:255',
                'description' => 'nullable|max:255',
            ]);

            $From = $Validation['from'];
            $To = $Validation['to'];

            $HolidayExists = Holiday::where(function ($i) use ($From, $To) {
                $i->where('to', '>=', $From)
                    ->where('from', '<=', $To);
            })->exists();

            if ($HolidayExists) {
                return throw new Exception('Holiday already exists , please select the another time period.');
            }

            Holiday::create($Validation);

            return response()->json(['success' => 'Holiday is Set Success fully']);
        } catch (ValidationException $v) {
            Log::info("Validation error in AddHoliday from HolidayController : " . $v);
            return response()->json(['error' => $v->getMessage()], 500);
        } catch (Exception $e) {
            Log::info("Error in AddHoliday from HolidayController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetHoliday()
    {
        try {
            $Holiday = Holiday::paginate(20);
            return response()->json(['Holiday' => $Holiday]);
        } catch (Exception $e) {
            Log::info("Error in GetHoliday from HolidayController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function RemoveHoliday(Request $request)
    {
        try {
            $Validation = $request->validate([
                'from' => 'required|date|before_or_equal:to',
                'to'   => 'required|date|after_or_equal:from',
                'title' => 'required|string|max:255',
            ]);

            $Holiday = Holiday::where('from', $Validation['from'])->where('to', $Validation['to'])->where('title', $Validation['title'])->first();

            if (!$Holiday) {
                throw new Exception('Entered Holiday Date does not exist');
            }

            $Holiday->delete();

            return response()->json(['success' => 'Entered Holiday is cancelled successfully.']);
        } catch (Exception $e) {
            Log::info("Error in RemoveHoliday from HolidayController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetCurrentMonthHolidayCount()
    {
        try {
            $CurrentMonthHoliday = Holiday::whereYear('from', Carbon::now()->year)->whereMonth('from', Carbon::now()->month)->whereMonth('to', Carbon::now()->month)->sum('days');

            // Following calculation for the holiday that start from current month and ends in next month (for example from 28 jan to 5 feb)
            // In this case (for example from 28 jan to 5 feb) if the current month is january then it only display the 4 which is only current month

            $HolidaysStartingThisMonthEndingLater = Holiday::whereYear('from', Carbon::now()->year)->whereMonth('from', Carbon::now()->month)->whereMonth('to', '!=', Carbon::now()->month)->whereYear('from', Carbon::now()->year)->value('from');
            if ($HolidaysStartingThisMonthEndingLater !== null) {
                $Day = Carbon::parse($HolidaysStartingThisMonthEndingLater)->day;
                $LastMonthDate = Carbon::now()->daysInMonth;
                $EndingMonthholiday = $LastMonthDate - $Day + 1;
            } else {
                $EndingMonthholiday = 0;
            }

            return response()->json(['holiday' => $EndingMonthholiday + $CurrentMonthHoliday]);
        } catch (Exception $e) {
            Log::info("Error in GetCurrentMonthHolidayCount from HolidayController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
