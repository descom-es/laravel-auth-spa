<?php

namespace Descom\AuthSpa\Http\Controllers\Passwords;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class ResetLinkController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        $httpStatus = $status === Password::RESET_LINK_SENT
            ? 200
            : 400;

        return response()->json(['message' => __($status)], $httpStatus);
    }
}
