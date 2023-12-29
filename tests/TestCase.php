<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\MakeJsonApi;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MakeJsonApi;
}
