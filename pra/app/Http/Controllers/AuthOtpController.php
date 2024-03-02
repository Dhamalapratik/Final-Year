<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationCodeModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Twilio\Rest\Client;

class AuthOtpController extends Controller
{
    // Generate OTP API
    public function generateOtp(Request $request)
    {
        // Validate Data
        $request->validate([
            'user_phone' => 'required|exists:users,user_phone'
        ]);

        // Generate an OTP for the user phone number
        $verificationCode = $this->generateOtpForUser($request->user_phone);

        // Return success response with OTP
        return response()->json([
            'message' => 'OTP generated successfully',
            'otp' => $verificationCode->otp,
            'user_phone' => $verificationCode->user_phone
        ]);
    }

    // Generate OTP for User
    public function generateOtpForUser($user_phone)
    {
        // Retrieve user based on user phone number
        $user = User::where('phonenumber', $user_phone)->first();

        // Check if user exists
        if ($user) {
            // abort(404, 'User not found');
            echo "user Exist";
        }

        // Check if user already has an existing OTP
        $verificationCode = VerificationCodeModel::where('user_phone', $user_phone)->latest()->first();

        $now = Carbon::now();

        // If there is a valid OTP, return it
        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        // Generate a new OTP
        $newVerificationCode = VerificationCodeModel::create([
            'user_phone' => $user_phone,
            'otp' => rand(123456, 999999),
            'user_id'=>1,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        // Send OTP via SMS
        $this->sendOtpSms($user_phone, $newVerificationCode->otp);

        return $newVerificationCode;
    }

    // Send OTP to mobile number via SMS
    private function sendOtpSms($mobile_no, $otp)
{
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_AUTH_TOKEN');
    $from = env('TWILIO_PHONE_NUMBER');

    // Format the phone number to include the country code for Nepal (+977)
    $formatted_mobile_no = '+977' . $mobile_no;

    $client = new Client($sid, $token);

    // Send SMS using Twilio
    $client->messages->create(
        $formatted_mobile_no,
        [
            'from' => $from,
            'body' => "Your OTP for the expense manager is: $otp"
        ]
    );
}


    // Verify OTP and Login API
    public function loginWithOtp(Request $request)
    {
        // Validation
        $request->validate([
            'user_phone' => 'required|exists:users,user_phone',
            'otp' => 'required'
        ]);

        // Verify OTP
        $verificationCode = VerificationCodeModel::where('user_phone', $request->user_phone)
            ->where('otp', $request->otp)
            ->first();

        $now = Carbon::now();

        if (!$verificationCode) {
            return response()->json(['error' => 'Invalid OTP'], 401);
        } elseif ($now->isAfter($verificationCode->expire_at)) {
            return response()->json(['error' => 'OTP expired'], 401);
        }

        // Expire the OTP
        $verificationCode->update([
            'expire_at' => $now
        ]);

        // Login the user
        $user = User::where('user_phone', $request->user_phone)->first();
        Auth::login($user);

        return response()->json(['message' => 'Login successful', 'user' => $user]);
    }
}
