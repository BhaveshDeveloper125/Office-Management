<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\UserLeave;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    public function CreateLeave(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'duration_type' => 'required|string|in:full,half',
                'from' => 'required|date|before_or_equal:to',
                'to' => 'required|date|after_or_equal:from',
                'leave_type' => 'required|string|in:medical,casual,other',
                'description' => 'nullable|string|max:255',
            ]);

            $from = $validated['from'];
            $to = $validated['to'];

            $leave = Leave::where('user_id', Auth::id())->where(function ($i) use ($from, $to) {
                $i->where('to', '>=', $from)->where('from', '<=', $to);
            })->exists();

            if ($leave) {
                return response()->json(['error' => 'Leave already exists between the selected time duration.'], 422);
            }

            $availableLeave = UserLeave::where('user_id',Auth::id())->sum('leaves');
            $askedLeave = Carbon::parse($from)->diffInDays(Carbon::parse($to));

            if ($askedLeave > $availableLeave) {
                return response()->json(['error' => 'you dont have enough leave credits'],422);
            }

            Leave::create($validated);

            return response()->json(['success' => 'Leave is Submitted Successfully.Please wait for the appropriate Response.']);
        } catch (Exception $e) {
            Log::info("Error in CreateLeave from LeaveController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function UpdateLeaveStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:leaves,id',
                'approve' => 'required|boolean',
            ]);

            $leave = Leave::find($validated['id']);

            if ($leave->to < Carbon::today()) {
                $leave->update(['status' => false]);    
                return response()->json(['error' => 'Cannot approve or reject past leaves and it considers them as rejected.'], 422);
            }

            unset($validated['id']);
            $leave->update($validated);

            return response()->json(['success' => 'Leave status updated successfully.']);
        } catch (Exception $e) {
            Log::info("Error in UpdateLeaveStatus from LeaveController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Employee leave history and status for the employee page 
    public function GetEmpLeaves()
    {
        try {
            $leave = Leave::where('user_id', Auth::id())->paginate(20);
            $leaves = $leave->toArray();
            $leaves['next'] = $leave->hasMorePages() ? $leave->currentPage() + 1 : null;
            $leaves['prev'] = $leave->onFirstPage() ? null : $leave->currentPage() - 1;
            return response()->json(['leaves' => $leaves]);
        } catch (Exception $e) {
            Log::info("Error in GetEmpLeaves from LeaveController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Employee leave history and status for the Admin page 
    public function GetAllLeaves(Request $request)
    {
        try {

            if ($request->is('admin/leaves/approved')) {
                $leaveApproval = Leave::where('approve', config('LeavesVars.leave_approval.Approved'))->with('user')->paginate(20);
                $leaveApproved = $leaveApproval->toArray();
                $leaveApproved['next'] = $leaveApproved['next_page_url'] ? $leaveApproved['current_page'] + 1 : null;
                $leaveApproved['prev'] = $leaveApproved['prev_page_url'] ? $leaveApproved['current_page'] - 1 : null;
                return response()->json(['approved' => $leaveApproved]);
            }else if ($request->is('admin/leaves/rejected')) {
                $leaveRejection = Leave::where('approve', config('LeavesVars.leave_approval.Rejected'))->with('user')->paginate(20);
                $leaveRejected = $leaveRejection->toArray();
                $leaveRejected['next'] = $leaveRejected['next_page_url'] ? $leaveRejected['current_page'] + 1 : null;
                $leaveRejected['prev'] = $leaveRejected['prev_page_url'] ? $leaveRejected['current_page'] - 1 : null;
                return response()->json(['rejected' => $leaveRejected]);
            }else if ($request->is('admin/leaves/pending')) {
                $leavePendings = Leave::where('approve', config('LeavesVars.leave_approval.pending'))->with('user')->paginate(20);
                $leavePending = $leavePendings->toArray();
                $leavePending['next'] = $leavePending['next_page_url'] ? $leavePending['current_page'] + 1 : null;
                $leavePending['prev'] = $leavePending['prev_page_url'] ? $leavePending['current_page'] - 1 : null;
                return response()->json(['pending' => $leavePending]);
            }else{
                return response()->json(['error' => 'Something definietly went wrong'], 404);
            }
            
        } catch (Exception $e) {
            Log::info("Error in GetAllLeaves from LeaveController : " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
