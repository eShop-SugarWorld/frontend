<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:user_auth,email',
            'password'   => 'required|min:6|confirmed',
        ],
            [
                'first_name.required' => 'Please provide your first name.',
                'first_name.string' => 'Your first name must be a valid string.',
                'first_name.max' => 'Your first name cannot exceed 255 characters.',
                'last_name.required' => 'Please provide your last name.',
                'last_name.string' => 'Your last name must be a valid string.',
                'last_name.max' => 'Your last name cannot exceed 255 characters.',
                'email.required' => 'Please provide your email.',
                'email.email' => 'Please provide a valid email address.',
                'email.unique' => 'This email is already in use.',
                'password.required' => 'Please provide a password.',
                'password.min' => 'Your password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
            ]);

        DB::beginTransaction();

        try {
            $userId = DB::table('user_info')->insertGetId([
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'phone_number' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('user_auth')->insert([
                'user_id' => $userId,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }else{
                return redirect()->route('login')->with('success', 'Account created successfully!');
            }


        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
            }

            return back()->withErrors(['error' => 'Something went wrong. Try again later.']);
        }
    }
}
