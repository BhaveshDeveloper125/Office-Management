<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function CheckIn()
    {
        try {
            Gate::authorize('CheckIn', Attendance::class);

            Attendance::create(['user_id' => Auth::id()]);

            return response()->json(['success' => 'Check in successfully.']);
        } catch (Exception $e) {
            Log::info("Error in CheckIn from AttendanceController : " . $e);
            // return redirect()->back()->with(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function CheckOut()
    {
        try {
            $affectedRows = Attendance::whereDate('checkin', Carbon::today())->where('user_id', Auth::id())->whereNull('checkout')->update(['checkout' => Carbon::now()]);

            if ($affectedRows) {
                return response()->json(['success' => 'Checkout successfully.']);
            } else {
                throw new Exception('Please check in first or you have already checkout.');
                // return response()->json('Please check in first or you have already checkout.');
            }
        } catch (Exception $e) {
            Log::info("Error in CheckOut from AttendanceController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
