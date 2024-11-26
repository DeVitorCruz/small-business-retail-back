<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;


class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse | RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        $token = $user->createToken('API Token')->plainTextToken;

        $tokenRecord = PersonalAccessToken::where('token', hash('sha256', explode('|', $token)[1]))->latest()->first();

        if ($tokenRecord) {
            $request->session()->put('auth_token_id', $tokenRecord->id);
        }


        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse | RedirectResponse
    {

        $token = $request->user()->currentAccessToken();

        $tokenId = $request->session()->get('auth_token_id');

        if ($token && !($token instanceof \Laravel\Sanctum\TransientToken)) {
            $token->delete();
        } else {
            $request->user()->tokens()->where('id', $tokenId)->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'User deleted successfully', 200]);
    }
}
