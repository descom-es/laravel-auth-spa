<?php

namespace Descom\AuthSpa\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(Auth::user());
    }
}
