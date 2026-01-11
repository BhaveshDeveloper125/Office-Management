<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function CheckOut()
    {
        try {
            $attendance = Attendance::where('user_id', Auth::id())->whereNull('checkout')->latest()->first();

            if ($attendance) {
                $attendance->update(['checkout' => Carbon::now()]);
                return response()->json(['success' => 'Checkout successfully.']);
            }

            throw new Exception('Please check in first or you have already checkout.');
        } catch (Exception $e) {
            Log::info("Error in CheckOut from AttendanceController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function LateCheckOutList()
    {
        try {
            $attendance = Attendance::where('user_id', Auth::id())->where('checkout', null)->with('user:id,name,email,mobile,post,qualification')->get(['id', 'user_id', 'checkin']);
            return response()->json(['attendance' => $attendance]);
        } catch (Exception $e) {
            Log::info("Error in LateCheckOut from AttendanceController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function AfterCheckouts(Request $request)
    {
        try {
            $validation = $request->validate([
                'id' => 'required|numeric|exists:attendances,id',
                'checkout' => 'required|date',
            ]);

            $attendance = Attendance::where('id', $validation['id'])->whereNull('checkout')->first();

            if (!$attendance) {
                return response()->json(['error' => 'Checkin details not found or already checked out.'], 404);
            }

            $attendance->update(['checkout' => $validation['checkout']]);

            return response()->json(['success' => 'Checkout successfully.']);
        } catch (Exception $e) {
            Log::info("Error in AfterCheckouts from AttendanceController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function EmpHistory()
    {
        try {
            $History = Attendance::whereYear('checkin', Carbon::now()->year)->whereMonth('checkin', Carbon::now()->month)->where('user_id', Auth::id())->with('user:id,working_from,working_to,hours')->get();
            return response()->json(['History' => $History]);
        } catch (Exception $e) {
            Log::info("Error in EmpHistory from AttendanceController : " . $e);
            return response()->json(['error' => $e], 500);
        }
    }

    public function CurrentMonthAttendanceReport()
    {
        try {
            $attendance = Attendance::whereMonth('checkin', Carbon::now()->month)->where('user_id', Auth::id())->count();
            $absent = Carbon::now()->day - $attendance;
            $late = Attendance::where('user_id', Auth::id())->whereMonth('checkin', Carbon::now()->month)->whereTime('checkin', '>', Auth::user()->working_from)->count();
            $early = Attendance::where('user_id', Auth::id())->whereMonth('checkout', Carbon::now()->month)->whereTime('checkout', '<', Auth::user()->working_to)->count();
            $overTime = Attendance::where('user_id', Auth::id())->whereMonth('checkout', Carbon::now()->month)->whereTime('checkout', '>', Auth::user()->working_to)->count();
            return response()->json(['attendance' => $attendance, 'absent' => $absent, 'late' => $late, 'early' => $early, 'overtime' => $overTime]);
        } catch (Exception $e) {
            Log::info('Error in CurrentMonthAttendanceReport from AttendanceController : ' . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function FilterHistory(Request $request)
    {
        try {
            $validated = $request->validate([
                'from' => 'required|date',
                'to' => 'nullable|date',
            ]);

            $attendance = Attendance::where('user_id', $request->user()->id)->where('checkin', '>=', $validated['from'])->with('user:id,working_from,working_to,hours')->when($validated['to'] ?? null, function ($query, $to) {
                $query->where('checkin', '<=', Carbon::parse($to)->endOfDay());
            })->paginate(20);

            $attendances = $attendance->toArray();
            $attendances['next'] = $attendance->hasMorePages() ? $attendance->currentPage() + 1 : null;
            $attendances['prev'] = $attendance->onFirstPage() ? null : $attendance->currentPage() - 1;

            return response()->json(['attendance' => $attendances]);
        } catch (Exception $e) {
            Log::info("Error in FilterHistory from AttendanceController : " . $e);
            return response()->json(['e' => $e->getMessage()], 500);
        }
    }
}
