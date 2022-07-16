<?php

namespace Descom\AuthSpa\Http\Controllers\Users;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileInfoController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(Auth::user());
    }
}
