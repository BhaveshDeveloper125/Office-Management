<?php

namespace App\Http\Controllers;

use App\Models\UserLeave;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserLeaveController extends Controller
{
    public function GetLeaveRecord()
    {
        try {
            $currentLeaves = UserLeave::where('user_id', Auth::id())->whereYear('year', Carbon::today()->year)->first();
            $previousYeasrLeave = UserLeave::where('user_id', Auth::id())->whereYear('year', '!=' ,  Carbon::today()->year)->sum('leaves');
            return response()->json(['status'=>true , 'message' => 'User Leaves are fetched successfully.' , 'currentLeaves' => $currentLeaves , 'previousYeasrLeave' => $previousYeasrLeave]);
        } catch (Exception $e) {
            return response()->json(['status'=> true, 'message' => 'Cant get the leave records','error' => $e],500);
        }
    }
}
