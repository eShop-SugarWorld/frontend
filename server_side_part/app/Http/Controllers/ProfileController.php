<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function account()
    {
        $user = auth()->user();
        $userInfo = $user->info;

        $orders = $userInfo->orders;

        return view('profile-page', compact('orders'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        Log::info('User attempts to change password', ['user_id' => $user->id]);

        if (!Hash::check($request->oldPassword, $user->password)) {
            return back()->withErrors(['oldPassword' => 'Old password is incorrect']);
        }
        Log::info('Password successfully changed', ['user_id' => $user->id]);

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }



    public function update(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone_number'=> [
                'nullable',
                'string',
                'max:255',
                'regex:/^(\+?\d{1,3}?)?(\d{7,15})$/',
            ],

        ]);
        $user = auth()->user();

        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->save();
        }
        echo $request->phone_number;
        echo "lol";
        if ($user->info) {
            $user->info->update([
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'phone_number'=> $request->phone_number,

            ]);
        } else {
            $user->info()->create([
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'phone_number'=> $request->phone_number,
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
