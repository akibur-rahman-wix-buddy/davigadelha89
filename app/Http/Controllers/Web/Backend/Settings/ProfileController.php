<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Exception;
use function App\Helpers\deleteFile;
use function App\Helpers\uploadFile;

class ProfileController extends Controller
{
    /**
     * Display the profile settings page.
     *
     * @return View
     */
    public function showProfile() {
        // Get the currently authenticated user's ID
        $userId = Auth::id();
        // Query the users table to get the user with the given ID
        $user = User::where('id', $userId)->first();
        return view('backend.layouts.settings.profile_settings', ['users' => $user]);
//         return view('backend.layouts.settings.profile_settings');
    }

    /**
     * Update the user's profile information.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'nullable|max:100|min:2',
            'email' => 'nullable|email|unique:users,email,' . auth()->user()->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::find(auth()->user()->id);
            $user->name  = $request->name;
            $user->email = $request->email;

            // Check Image Update
            if ($request->hasFile('avatar')) {
                // If an avatar already exists, delete the old file
                if ($user->avatar) {
                    Helper::deleteFile($user->avatar);
                }

                // Store the new image in the storage and get the public path
                $featuredImage = Helper::uploadFile($request->file('avatar'), 'user-avatar');
                $user->avatar = $featuredImage;
            }

            $user->save();

            return redirect()->back()->with('notify-success', 'Profile Updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('notify-warning', 'Something went wrong');
        }
    }


    /**
     * Update the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password'     => 'required|confirmed|min:8',
            'password_confirmation'     => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $user = Auth::user();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();

                return redirect()->back()->with('notify-success', 'Password Updated Successfully');
            } else {
                return redirect()->back()->with('notify-warning', 'Current password is incorrect');
            }
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Something went wrong');
        }
    }
}
