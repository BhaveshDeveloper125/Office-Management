<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHomePageController extends Controller
{
    public function Cards()
    {
        try {
            $totalEmp = User::role('Employee')->count();
            $presentToday = Attendance::whereDate('checkin', Carbon::today())->count();
            $lateToday = Attendance::whereDate('checkin', Carbon::now()->today())->whereTime('checkin', '>', Auth::user()->working_from)->count();
            $leaveToday = Attendance::whereDate('checkout', Carbon::today())->count();
            $absentToday = $totalEmp - $presentToday;
            $earlyLeave = Attendance::whereDate('checkout', Carbon::today())->whereTime('checkout', '<', Auth::user()->working_to)->count();
            $today = Carbon::today();
            $overallHoliday = Holiday::where(function ($i) {
                $i->whereYear('to', Carbon::now()->year)->orWhereYear('to', Carbon::now()->addYear()->year);
            })->get()->sum(function ($holiday) use ($today) {
                $to = Carbon::parse($holiday->to);
                $from = Carbon::parse($holiday->from);

                if ($to->lt($today)) {
                    return 0;
                } elseif ($from->gte($today)) {
                    return $holiday->days;
                } else {
                    return $today->diffInDays($to) + 1;
                }
            });
            $requestedLeaves = Leave::where('approve', null)->count();
            return response()->json(['totalEmp' => $totalEmp, 'presentToday' => $presentToday, 'lateToday' => $lateToday, 'leaveToday' => $leaveToday, 'absentToday' => $absentToday, 'earlyLeave' => $earlyLeave, 'overallHoliday' => $overallHoliday , 'requestedLeaves' => $requestedLeaves]);
        } catch (Exception $e) {
            logger("Error in Cards In AdminHomePageController : " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
