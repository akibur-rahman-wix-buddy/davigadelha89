<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => false,
            ], 400);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone
            ]);

            $token = JWTAuth::fromUser($user);
            // Generate OTP
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expiration = Carbon::now()->addMinutes(15);
            $user->save();

            // Send OTP via email
            Mail::send('emails.otp-reg', ['otp' => $otp], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your Registration OTP');
            });

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully. Please check your email for the OTP.',
                'token' => $token
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyRegistrationOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if ($user->otp != $request->otp || Carbon::now()->greaterThan($user->otp_expiration)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired OTP.',
                ], 400);
            }

            $user->email_verified_at = Carbon::now();
            $user->otp = null;
            $user->otp_expiration = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying OTP.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function resendRegistrationOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $user = User::where('email', $request->email)->first();

            // Generate new OTP
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expiration = Carbon::now()->addMinutes(15);
            $user->save();

            // Send OTP via email
            Mail::send('emails.otp-reg', ['otp' => $otp], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your Registration OTP');
            });

            return response()->json([
                'success' => true,
                'message' => 'A new OTP has been sent to your email.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while resending OTP.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Get the authenticated user
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'token' => $token,
            'email_verified' => $user->hasVerifiedEmail(),
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

//    public function logout()
//    {
//        try {
//            auth()->logout(); // Invalidate the token
//            return response()->json([
//                'success' => true,
//                'message' => 'Successfully logged out'
//            ]);
//        } catch (Exception $e) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Failed to log out, please try again'
//            ], 500);
//        }
//    }


    public function refresh()
    {
        $newToken = JWTAuth::refresh();

        return response()->json(['token' => $newToken]);
    }
    public function show()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => "nullable|string|email|max:255|unique:users,email,{$user->id}",
//            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048'
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => false,
            ], 400);
        }

        if ($request->hasFile('avatar')) {
            $profileImagePath = Helper::fileUpload($request->file('avatar'), 'profile_images', $user->name);
            $user->avatar = $profileImagePath;
        }

        $user->update($request->only('name', 'email'));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => false,
            ], 400);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The old password is incorrect'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    }

    public function sendResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $user = User::where('email', $request->email)->first();

            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expiration = Carbon::now()->addMinutes(15);
            $user->save();

            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your Password Reset OTP');
            });

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully. Please check your email.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending OTP.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if ($user->otp != $request->otp || Carbon::now()->greaterThan($user->otp_expiration)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired OTP.',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying OTP.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'otp' => 'required|numeric',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if ($user->otp != $request->otp || Carbon::now()->greaterThan($user->otp_expiration)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired OTP.',
                ], 400);
            }

            $user->password = Hash::make($request->new_password);
            $user->otp = null;
            $user->otp_expiration = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while resetting password.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
