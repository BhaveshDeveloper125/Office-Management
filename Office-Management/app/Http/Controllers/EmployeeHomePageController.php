<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\WeeklyHoliday;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeHomePageController extends Controller
{
    public function CurrentMonthWorkingDays()
    {
        try {
            // ------------------------------ Weekend Count ------------------------------//
            $Weekend = WeeklyHoliday::pluck('day')->toArray();
            if (Auth::user()->joining->isCurrentYear() && Auth::user()->joining->isCurrentMonth()) {
                $StartOfMonth = Auth::user()->joining;
            } else {
                $StartOfMonth = Carbon::now()->startOfMonth();
            }
            $EndOfMonth = Carbon::now()->endOfMonth();

            $counter = 0;

            while ($StartOfMonth->lte($EndOfMonth)) {
                if (!in_array($StartOfMonth->isoWeekday(), $Weekend)) {
                    $counter++;
                }
                $StartOfMonth->addDay();
            }
            // ------------------------------ /Weekend Count ------------------------------//

            // ------------------------------ Holiday Count ------------------------------//
            // Following calculation for the holiday that start from current month and ends in next month (for example from 28 jan to 5 feb)
            // In this case (for example from 28 jan to 5 feb) if the current month is january then it only display the 4 which is only current month
            $CurrentMonthHoliday = Holiday::whereYear('from', Carbon::now()->year)->whereMonth('from', Carbon::now()->month)->whereMonth('to', Carbon::now()->month)->sum('days');
            $HolidaysStartingThisMonthEndingLater = Holiday::whereYear('from', Carbon::now()->year)->whereMonth('from', Carbon::now()->month)->whereMonth('to', '!=', Carbon::now()->month)->whereYear('from', Carbon::now()->year)->value('from');
            $EndingMonthholiday = 0;
            if ($HolidaysStartingThisMonthEndingLater) {
                $Day = Carbon::parse($HolidaysStartingThisMonthEndingLater)->day;
                $LastMonthDate = Carbon::now()->daysInMonth;
                $EndingMonthholiday = $LastMonthDate - $Day + 1;
            }

            $holiday = $EndingMonthholiday + $CurrentMonthHoliday;
            $currentworkingdays = $counter  - $holiday;
            // ------------------------------ /Holiday Count ------------------------------//

            // ------------------------------ Remaining Working Day Count ------------------------------//
            $currentDate = Carbon::now();
            $RemainingDaysExcludingWeekend = 0;
            while ($currentDate->lte($EndOfMonth)) {
                if (!in_array($currentDate->isoWeekday(), $Weekend)) {
                    $RemainingDaysExcludingWeekend++;
                }
                $currentDate->addDay();
            }

            $RemainingHoliday = Holiday::whereYear('from', Carbon::now()->year)->whereMonth('from', Carbon::now()->month)->whereMonth('to', Carbon::now()->month)->where('from', '>', Carbon::now())->sum('days');
            $TotalRemovableDays = $RemainingHoliday + $EndingMonthholiday;
            $Remainingdays = $RemainingDaysExcludingWeekend - $TotalRemovableDays;
            // ------------------------------ /Remaining Working Day Count ------------------------------//

            return response()->json(['currentworkingdays' => $currentworkingdays, 'remainingdays' => $Remainingdays]);
        } catch (Exception $e) {
            Log::info("Error in CurrentMonthWorkingDays from EmployeeHomePageController : " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function GetAttendanceData(Request $request)
    {
        try {
            switch ($request->path()) {
                case 'employee_attendance_data':
                    return response()->json('employee_attendance_data');
                    break;
                case 'employee_late_data':
                    return response()->json('employee_late_data');
                    break;
                case 'employee_early_data':
                    return response()->json('employee_early_data');
                    break;
                case 'employee_absent_data':
                    return response()->json('employee_absent_data');
                    break;
                case 'employee_overtime_data':
                    return response()->json('employee_overtime_data');
                    break;
                case 'employee_holiday_data':
                    return response()->json('employee_holiday_data');
                    break;
                case 'employee_workingdays_data':
                    return response()->json('employee_workingdays_data');
                    break;
                case 'employee_remainingworkingdays_data':
                    return response()->json('employee_remainingworkingdays_data');
                    break;
                default:
                    return response()->json(['error' => 'Invalid Attendance Data'], 400);
            }

            return response()->json(['success' => 'Attendance Data']);
        } catch (Exception $e) {
            Log::info("Error in GetAttendanceData from EmployeeHomePageController : " . $e);
            return response()->json(['error' => $e->getMessage(), 500]);
        }
    }
}
