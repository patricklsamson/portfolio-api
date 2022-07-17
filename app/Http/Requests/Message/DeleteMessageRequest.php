<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;

class DeleteMessageRequest extends Request implements RequestInterface
{
    /**
     * Get data to be validated from the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function data(Request $request): array
    {
        return $request->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
