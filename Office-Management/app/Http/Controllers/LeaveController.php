<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    public function CreateLeave(Request $request)
    {
        try {
            $validated=$request->validate([
                'title'=>'required|string|max:255',
                'duration_type'=>'required|string|in:full,half',
                'from'=>'required|date|before_or_equal:to',
                'to'=>'required|date|after_or_equal:from',
                'leave_type'=>'required|string|in:medical,casual,other',
                'description'=>'nullable|string|max:255',
            ]);

            $from=$validated['from'];
            $to=$validated['to'];

            $leave = Leave::where('user_id',Auth::id())->where(function($i) use($from,$to){
                $i->where('to','>=',$from)->where('from','<=',$to);
            })->exists();

            if ($leave) {
                return response()->json(['error'=>'Leave already exists between the selected time duration.'],422);
            }

            Leave::create($validated);

            return response()->json(['success'=>'Leave is Submitted Successfully.Please wait for the appropriate Response.']);
        } catch (Exception $e) {
            Log::info("Error in CreateLeave from LeaveController : " . $e);
        }
    }
}
