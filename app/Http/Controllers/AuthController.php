<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Handle logout
    public function logout()
    {
        Auth::logout();  // Log out the user
        return redirect()->route('login');  // Redirect to the login page
    }



    public function loginform()
    {
        return view('auth.login');  
    }


    public function registerform()
    {
        return view('auth.register');  
    }
    public function error403()
    {
        return view('auth.errors.error403');  
    }





    public function register(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create a new user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful');
    }


    public function login(Request $request)
    {
        // Validate the input credentials
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            } else {
                return redirect()->route('user.dashboard'); // Redirect to user dashboard (or any other route)
            }
        } else {
            // Authentication failed
            return back()->withErrors(['email' => 'The provided credentials are incorrect.'])->withInput();
        }
    }


}
