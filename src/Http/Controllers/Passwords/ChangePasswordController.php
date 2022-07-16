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
            'password' => 'required|min:8|confirmed|different:current_password',
        ]);

        $this->resetPasswordforCurrentUser($request->input('password'));

        return response()->json(['message' => 'Contraseña cambiada correctamente'], 200);
    }

    private function resetPasswordforCurrentUser(string $password): void
    {
        $userLogged = Auth::user();

        $userLogged->forceFill([
            'password' => Hash::make($password),
        ])->setRememberToken(Str::random(60));

        $userLogged->save();

        event(new PasswordReset($userLogged));
    }
}
