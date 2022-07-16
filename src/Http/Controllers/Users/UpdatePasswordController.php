<?php

namespace Descom\AuthSpa\Http\Controllers\Users;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => [
                'required',
                'confirmed',
                'different:current_password',
                Password::default(),
            ],
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
