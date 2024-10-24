<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'device_name' => ['required']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3,
        ]);

        event(new Registered($user));

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }

    
    public function googleLogin(Request $request)
    {
        $request->validate([
            'idToken' => 'required|string', // Validate the ID token
            'device_name' => 'required'
        ]);

        // Verify the ID token with Google
        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);  // Specify your CLIENT_ID from Google Developer Console
        $payload = $client->verifyIdToken($request->idToken);

        if ($payload) {
            $googleId = $payload['sub']; // Google ID
            $email = $payload['email'];
            $name = $payload['name'];

            // Find or create the user in the database
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make(uniqid()), // Generate a random password
                    'role_id' => 3,
                ]
            );

            return response()->json([
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ], 200);
        }

        return response()->json(['error' => 'Invalid Google token'], 401);
    }
}
