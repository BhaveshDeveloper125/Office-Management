<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Usercontroller extends Controller
{
    public function Register(UserValidationRequest $request)
    {
        try {
            $Validation = $request->validated();
            $Validation['password'] = bcrypt($Validation['password']);
            $Role = $Validation['role'];
            unset($Validation['role']);

            $user = User::create($Validation);

            $user->assignRole($Role);

            return response()->json(['success' => 'User Registered Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            Log::info("Error in User Register: " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function Login(Request $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function GetEmpList()
    {
        try {
            $EmpDetails = User::paginate(20);
            return response()->json(['EmpDetails' => $EmpDetails]);
        } catch (Exception $e) {
            Log::info("Error in GetEmpDetails: " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function FilterEmpList(Request $request)
    {
        try {
            $Validation = $request->validate([
                'from' => 'required|date',
                'to' => 'required|date|after_or_equal:from',
            ]);

            $from = Carbon::parse($Validation['from'])->startOfDay();
            $to = Carbon::parse($Validation['to'])->endOfDay();

            $EmpDetails = User::whereBetween('joining', [$from, $to])->paginate(20);

            return response()->json(['EmpDetails' => $EmpDetails]);
        } catch (Exception $e) {
            Log::info("Error in FilterEmpList: " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function UpdateEmp(Request $request)
    {
        try {
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            Log::info("Error in UpdateEmp: " . $th);
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function SearchEmp(Request $request)
    {
        try {
            $Validation = $request->validate(['search' => 'required|string']);

            $EmpDetails = User::where('name', 'like', '%' . $Validation['search'] . '%')->get();

            if ($EmpDetails->isEmpty()) {
                return response()->json(['EmpDetails' => []]);
            }

            return response()->json(['EmpDetails' => $EmpDetails]);
        } catch (Exception $e) {
            Log::info("Error in SearchEmp : " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
