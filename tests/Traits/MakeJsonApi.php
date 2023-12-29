<?php

namespace Tests\Traits;

use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;

trait MakeJsonApi
{

    public function json($method, $uri, array $data = [], array $headers = [], $options = 0)
    {
        $headers['accept'] = 'application/json';

        return parent::json($method, $uri, $data, $headers, $options);
    }

    public function postJson($uri, array $data = [], array $headers = [], $options = 0)
    {

        $headers['content-type'] = 'application/json';

        return parent::postJson($uri, $data, $headers, $options);
    }

    public function patchJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        $headers['content-type'] = 'application/json';

        return parent::patchJson($uri, $data, $headers, $options);
    }

}