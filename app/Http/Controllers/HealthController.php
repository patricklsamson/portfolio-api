<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerException;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    use ResponseTrait;

    /**
     * Health check
     *
     * @return Response
     */
    public function check(): Response
    {
        throw_if(!DB::getPdo(), InternalServerException::class);

        return response($this->content([
            'name' => 'Porfolio API',
            'version' => 'v1',
            'status' => 'UP',
            'framework' => app()->version()
        ]));
    }
}
