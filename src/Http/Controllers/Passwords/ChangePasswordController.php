<?php

namespace Descom\AuthSpa\Http\Controllers\Passwords;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

        if (!Hash::check($request->input('current_password'), auth()->user()->password)) {
            return response()->json(['message' => __('auth.passwords.change_mismatch')], 400);
        }

        auth()->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json(['message' => 'culo'], 200);
    }
}
