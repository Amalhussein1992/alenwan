<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'device_id' => 'required|string',
            'device_name' => 'required|string',
            'device_type' => 'required|string',
            'platform' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'subscription_tier' => 'free',
            'max_devices' => 2,
        ]);

        // Create device record
        $device = UserDevice::create([
            'user_id' => $user->id,
            'device_id' => $request->device_id,
            'device_name' => $request->device_name,
            'device_type' => $request->device_type,
            'platform' => $request->platform,
            'last_used_at' => now(),
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
                'device' => $device,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'device_id' => 'required|string',
            'device_name' => 'required|string',
            'device_type' => 'required|string',
            'platform' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account is disabled'
            ], 403);
        }

        // Check device management
        $existingDevice = UserDevice::where([
            'user_id' => $user->id,
            'device_id' => $request->device_id
        ])->first();

        if (!$existingDevice) {
            if (!$user->canAddDevice()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Maximum device limit reached',
                    'data' => [
                        'max_devices' => $user->max_devices,
                        'current_devices' => $user->devices()->where('is_active', true)->count()
                    ]
                ], 403);
            }

            // Create new device
            $existingDevice = UserDevice::create([
                'user_id' => $user->id,
                'device_id' => $request->device_id,
                'device_name' => $request->device_name,
                'device_type' => $request->device_type,
                'platform' => $request->platform,
                'last_used_at' => now(),
            ]);
        } else {
            // Update existing device
            $existingDevice->update([
                'device_name' => $request->device_name,
                'device_type' => $request->device_type,
                'platform' => $request->platform,
                'last_used_at' => now(),
                'is_active' => true,
            ]);
        }

        $token = $user->createToken('auth-token', ['*'], now()->addDays(30))->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => $user->load('devices'),
                'token' => $token,
                'subscription' => [
                    'tier' => $user->subscription_tier,
                    'expires_at' => $user->subscription_expires_at,
                    'is_active' => $user->hasActiveSubscription(),
                ]
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load(['devices' => function($query) {
            $query->where('is_active', true);
        }]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'subscription' => [
                    'tier' => $user->subscription_tier,
                    'expires_at' => $user->subscription_expires_at,
                    'is_active' => $user->hasActiveSubscription(),
                    'can_access_premium' => $user->canAccessContent('premium'),
                    'can_access_platinum' => $user->canAccessContent('platinum'),
                ]
            ]
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();

        $token = $user->createToken('auth-token', ['*'], now()->addDays(30))->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Token refreshed successfully',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'profile_image' => 'sometimes|string',
            'preferences' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $user->update($request->only(['name', 'profile_image', 'preferences']));

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => ['user' => $user]
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully'
        ]);
    }

    public function removeDevice(Request $request, $deviceId)
    {
        $user = $request->user();
        $device = UserDevice::where('user_id', $user->id)
                            ->where('device_id', $deviceId)
                            ->first();

        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device not found'
            ], 404);
        }

        $device->update(['is_active' => false]);

        return response()->json([
            'status' => 'success',
            'message' => 'Device removed successfully',
            'data' => [
                'devices' => $user->devices()->where('is_active', true)->get()
            ]
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would typically send a password reset email
        // For now, we'll just return a success message

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset link sent to your email'
        ]);
    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider' => 'required|in:google,facebook',
            'provider_id' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string',
            'avatar' => 'sometimes|string',
            'device_id' => 'required|string',
            'device_name' => 'required|string',
            'device_type' => 'required|string',
            'platform' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find or create user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'profile_image' => $request->avatar,
                'password' => Hash::make(uniqid()), // Random password for social users
                'subscription_tier' => 'free',
                'max_devices' => 2,
            ]);
        }

        // Handle device
        $device = UserDevice::firstOrCreate([
            'user_id' => $user->id,
            'device_id' => $request->device_id
        ], [
            'device_name' => $request->device_name,
            'device_type' => $request->device_type,
            'platform' => $request->platform,
            'last_used_at' => now(),
        ]);

        $device->update(['last_used_at' => now()]);

        $token = $user->createToken('auth-token', ['*'], now()->addDays(30))->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Social login successful',
            'data' => [
                'user' => $user->load('devices'),
                'token' => $token,
                'subscription' => [
                    'tier' => $user->subscription_tier,
                    'expires_at' => $user->subscription_expires_at,
                    'is_active' => $user->hasActiveSubscription(),
                ]
            ]
        ]);
    }
}