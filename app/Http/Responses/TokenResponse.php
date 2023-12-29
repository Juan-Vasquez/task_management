<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Support\Responsable;

class TokenResponse implements Responsable
{

    private $token;
    private $code;
    
    public function __construct($token, $code)
    {
        $this->token = $token;
        $this->code = $code;
    }

    public function toResponse($request)
    {
        return response()->json([
            'access_token' => $this->token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ], $this->code);
    }

}
