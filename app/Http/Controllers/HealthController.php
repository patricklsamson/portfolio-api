<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;

class HealthController extends Controller
{
    use ResponseTrait;

    /**
     * Health check
     *
     * @return mixed
     */
    public function check()
    {
        return response($this->buildContent([
            'name' => 'Porfolio API',
            'version' => 'v1',
            'status' => 'UP',
            'framework' => app()->version()
        ]));
    }
}
