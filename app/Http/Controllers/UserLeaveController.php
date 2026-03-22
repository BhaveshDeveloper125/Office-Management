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
            $previousYeasrLeave = UserLeave::where('user_id', Auth::id())->whereYear('year', '!=' ,  Carbon::today()->year)->sum('leaves');
            $previousYeasrLeaveList = UserLeave::where('user_id', Auth::id())->whereYear('year', '!=' ,  Carbon::today()->year)->get();
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

            // logger($applyPayCust->pay_request);
            return response()->json(['success' => 'Applie the request for the leave pay cut.']);
        } catch (Exception $e) {
            logger("Error in ApplyPayOnLeave from UserLeaveController : " . $e);
            return response()->json(['error' => $e],500);
        }
    }
}
