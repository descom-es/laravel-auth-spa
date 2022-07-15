<?php

namespace Descom\AuthSpa\Http\Controllers\Passwords;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ChangePasswordController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($request->input('current_password') === $request->input('password')) {
            return response()->json(['message' => __('auth.passwords.change_mismatch')], 400);
        }



        if (!Hash::check($request->input('current_password'), Auth::user()->getAuthPassword())) {
            return response()->json(['message' => __('auth.passwords.change_mismatch')], 400);
        }

        Password::reset([
            'email' => Auth::user()->email,
            'password' => $request->input('password'),
        ]);

        return response()->json(['message' => 'Contraseña cambiada correctamente'], 200);
    }
}
