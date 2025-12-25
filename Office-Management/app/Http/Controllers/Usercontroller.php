<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
