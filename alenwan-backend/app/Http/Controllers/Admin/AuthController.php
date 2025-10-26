<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if user has admin role
            if ($user->role !== 'admin') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login successful! Welcome back, ' . $user->name,
                'redirect' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials. Please check your email and password.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully!'
            ]);
        }

        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}