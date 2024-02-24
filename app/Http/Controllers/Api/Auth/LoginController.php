<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\TokenResponse;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return new TokenResponse($token, 200);
        }

        return response()->json(['error' => 'Incorrect credentials'], 400);

    }

    public function guard()
    {
        return Auth::guard();
    }

}
