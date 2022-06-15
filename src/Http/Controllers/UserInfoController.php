<?php

namespace Descom\AuthSpa\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(Auth::user());
    }
}
