<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function CreateResetPasswordToken(Request $request)
    {
        try {
            $validate = $request->validate([
                'email' => 'required|email|exists:users,email'
            ]);

            $token = Str::random(64);

            DB::table('password_reset_tokens')->insert([
              'email'     => $validate['email'],
              'token'     => $token,
              'created_at'=> Carbon::now(),  
            ]);

            return redirect()->back()->with(['success' => 'Password reset link is send to the mail']);



        } catch (Exception $e) {
            logger("Error in CreatePasswordToken from ForgotPasswordController : ".$e);
            return redirect()->back()->with(['status' => false , 'message' => 'Can not generate the reset password link' , 'error' => $e],500);
        }
    }
}
