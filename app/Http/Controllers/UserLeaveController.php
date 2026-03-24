<?php

namespace App\Http\Controllers;

use App\Models\UserLeave;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserLeaveController extends Controller
{
    public function GetLeaveRecord()
    {
        try {
            $currentLeaves = UserLeave::where('user_id', Auth::id())->whereYear('year', Carbon::today()->year)->first();
            $previousYeasrLeave = UserLeave::where('user_id', Auth::id())->whereYear('year', '!=' ,  Carbon::today()->year)->where('pay_request' , false)->sum('leaves');
            $previousYeasrLeaveList = UserLeave::where('user_id', Auth::id())->whereYear('year', '!=' ,  Carbon::today()->year)->where('pay_request' , false)->get();
            return response()->json(['status'=>true , 'message' => 'User Leaves are fetched successfully.' , 'currentLeaves' => $currentLeaves , 'previousYeasrLeave' => $previousYeasrLeave , 'previousYeasrLeaveList' => $previousYeasrLeaveList]);
        } catch (Exception $e) {
            return response()->json(['status'=> true, 'message' => 'Cant get the leave records','error' => $e],500);
        }
    }

    public function ApplyPayOnLeave(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:user_leaves,id'
            ]);

            $applyPayCust = UserLeave::find($validated['id']);

            // Cant apply for the pay leave if emp has 0 leaves remain and leave should belongs to previous years
            if ($applyPayCust->leaves <= 0 || $applyPayCust->year_extracted == Carbon::today()->year) {
                return response()->json(['error' => 'You may not have the previous years leave credit.'],500);
            }

            $applyPayCust->update(['pay_request' => null]);

            return response()->json(['success' => 'Applie the request for the leave pay cut.']);
        } catch (Exception $e) {
            logger("Error in ApplyPayOnLeave from UserLeaveController : " . $e);
            return response()->json(['error' => $e],500);
        }
    }

    public function AppliedLeaveList()
    {
        try {
            $appliedLeaves = UserLeave::with('user')->where('pay_request', null)
                ->whereHas('user', function ($i) {
                $i->role('Employee');
                })->get();
            return response()->json(['appliedLeaves' => $appliedLeaves]);
        } catch (Exception $e) {
            logger("Error in AppliedLeaveList from UserLeaveController : " . $e);
            return response()->json([ 'message' => 'Can Not Fetch The Applied Leaves' , 'error' => $e],500);
        }
    }

    public function PayLeaveApprove(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:user_leaves,id'
            ]);
            $approve = UserLeave::find($validated['id']);
            $approve->update(['pay_request' => true]);
            return response()->json(['success' => 'Pay leave approved successfully.']);
        } catch (Exception $e) {
            logger("Error in PayLeaveApprove from UserLeaveController : " . $e);
            return response()->json([ 'message' => 'Can Not Approve The Applied Leaves' , 'error' => $e],500);
        }
    }

    public function PayLeaveReject(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:user_leaves,id'
            ]);
            $reject = UserLeave::find($validated['id']);
            $reject->update(['pay_request' => false]);
            return response()->json(['success' => 'Pay leave rejected successfully.']);
        } catch (Exception $e) {
            logger("Error in PayLeaveReject from UserLeaveController : " . $e);
            return response()->json([ 'message' => 'Can Not Approve The Applied Leaves' , 'error' => $e],500);
        }
    }
}
