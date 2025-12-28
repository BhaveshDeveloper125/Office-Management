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
                'date' => 'required|date|after_or_equal:today',
                'title' => 'required|string|max:255',
                'description' => 'nullable|max:255',
            ]);

            Holiday::create($Validation);

            return response()->json(['success' => $Validation['title'] . " holiday is set " . " on " . Carbon::parse($Validation['date'])->format('jS M Y')]);
        } catch (ValidationException $v) {
            Log::info("Validation error in AddHoliday from HolidayController : " . $v);
            return response()->json(['error' => $v], 500);
        } catch (Exception $e) {
            Log::info("Error in AddHoliday from HolidayController : " . $e);
            return response()->json(['error' => $e], 500);
        }
    }
}
