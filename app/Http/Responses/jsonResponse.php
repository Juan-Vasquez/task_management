<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class jsonResponse implements Responsable
{
    private $message;
    private $data;
    private $code;
    private $error;

    public function __construct($data, $message, $error, $code = 200)
    {
        $this->message = $message;
        $this->data = $data;
        $this->error = $error;
        $this->code = $code;
    }

    public function toResponse($request)                                                                                                                                                                                                                    
    {
        return response()->json([
            'code' => $this->code,
            'error' => $this->error,
            'data' => $this->data,
            'message' => $this->message
        ], $this->code);
    }
}