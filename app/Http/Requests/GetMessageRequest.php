<?php

namespace App\Http\Requests;

use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;

class GetMessageRequest extends Request implements RequestInterface
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function data(): array
    {
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
