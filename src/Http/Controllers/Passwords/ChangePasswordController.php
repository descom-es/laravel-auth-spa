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
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($request->input('current_password') === $request->input('password')) {
            return response()->json(['message' => __('auth.passwords.change_mismatch')], 400);
        }

        $userLogged = Auth::user();

        $userLogged->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->setRememberToken(Str::random(60));

        $userLogged->save();

        event(new PasswordReset($userLogged));

        return response()->json(['message' => 'Contraseña cambiada correctamente'], 200);
    }
}
