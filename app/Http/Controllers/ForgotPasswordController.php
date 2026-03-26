<?php

namespace App\Http\Controllers;

use App\Mail\ForgotEmail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            
            Mail::to($validate['email'])->send(new ForgotEmail(['subject' => 'Reset Email' , 'token' => $token , 'email' => $validate['email']]));

            return redirect()->back()->with(['success' => 'Password reset link is send to the mail']);

        } catch (Exception $e) {
            logger("Error in CreatePasswordToken from ForgotPasswordController : ".$e);
            return redirect()->back()->with(['status' => false , 'message' => 'Can not generate the reset password link' , 'error' => $e],500);
        }
    }

    public function ResetPassword(Request $request)
    {
        try {
                $validate = $request->validate([
                    'token'    => 'required|string',
                    'email'    => 'required|email|exists:users,email',
                    'password' => 'required|string|min:8|confirmed'
                ]);

                $record = DB::table('password_reset_tokens')->where('token', $validate['token'])->where('email', $validate['email'])->first();

                if (!$record) {
                    return response()->json(['status'  => false,'message' => 'Entered email did not requested for the reset password.'], 404);
                }

                if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
                    DB::table('password_reset_tokens')->where('token', $validate['token'])->where('email', $validate['email'])->delete();
                    return response()->json(['status'  => false,'message' => 'Link is expired for the Password reset.'], 410);
                }

                User::where('email', $validate['email'])->update(['password' => bcrypt($validate['password'])]);

                DB::table('password_reset_tokens')->where('token', $validate['token'])->where('email', $validate['email'])->delete();

                return response()->json(['status'  => true,'message' => 'Password is updated successfully.']);
            
        } catch (Exception $e) {
            logger("Error in ResetPassword from ForgotPasswordController : ".$e);
            return redirect()->back()->with(['status' => false , 'message' => 'Can not reset the reset password link' , 'error' => $e],500);
        }
    }
}
