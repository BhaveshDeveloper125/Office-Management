<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        } catch (Exception $e) {
            Log::info("Error in User Register: " . $e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function Login(Request $request)
    {
        try {
            $Validation = $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|',
            ]);

            if (Auth::attempt($Validation)) {
                return redirect('/')->with(['success' => 'User is login successfully.']);
            } else {
                return redirect()->back()->with(['error' => 'Invalid Credentials']);
            }
        } catch (Exception $e) {
            Log::info("Error in Login from Usercontroller: " . $e);
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
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

    public function UpdateEmp(UserValidationRequest $request)
    {
        try {
            $Validation = $request->validated();
            $user = User::find($Validation['id']);
            $user->update($Validation);
            return redirect()->back()->with(['success' => 'User Updated Successfully']);
        } catch (ValidationException $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            Log::info("Error in UpdateEmp: " . $e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function UpdateUser(UserValidationRequest $request)
    {
        try {
            $Validation = $request->validated();
            User::find(Auth::id())->update($Validation);
            return response()->json(['success' => 'User Updated Successfully']);
        } catch (ValidationException $e) {
            Log::info(" Error in UpdateUser validation from Usercontroller :  " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            Log::info("Error in UpdateUser from Usercontroller : " . $e);
            return response()->json(['error' => $e->getMessage()]);
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

    public function ChangePassword(Request $request)
    {
        try {
            $Validation = $request->validate([
                'email' => 'required|string|email|max:255|exists:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $Update = User::where('email', $Validation['email'])->update(['password' => bcrypt($Validation['password'])]);

            return response()->json(['success' => 'Password is changed successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            Log::info("Error in ChangePassword: " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function DeleteEmployee(Request $request)
    {
        try {
            $Validation = $request->validate(['id' => 'required|exists:users,id']);
            $user = User::find($Validation['id']);
            $user->delete();
            return redirect('/admin')->with(['success' => 'User deleted successfully.']);
        } catch (Exception $e) {
            Log::info("Error in DeleteEmployee: " . $e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function ForgotPassword(UserValidationRequest $request)
    {
        try {
            //code...
        } catch (Exception $e) {
            logger("Error in ForgotPassword from Usercontroller : " . $e);
            return response()->json(['status' => false , 'message' => 'Password update request is not sent'],500);
        }
    }

    public function Logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('Login Page')->with(['success' => 'User is logout successfully.']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
