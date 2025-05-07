<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('user_auth')->where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $userModel = User::find($user->user_id);

            Auth::login($userModel);
            if ($userModel->email === '090705jk@gmail.com') {
                session(['is_admin' => true]);
                return redirect()->route('admin');
            }

            session(['is_admin' => false]);
            return redirect()->route('home');
        }
        return back()->withErrors([
            'email' => 'Invalid email or password',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('is_admin');
        return redirect()->route('home');
    }
}
