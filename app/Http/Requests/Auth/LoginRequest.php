<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;

class LoginRequest extends Request implements RequestInterface
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
        $attributes = 'data.attributes';

        return [
            'data' => 'required|array:attributes',
            $attributes => 'required|array:email,password',
            "$attributes.email" => 'required|string|min:1|max:50',
            "$attributes.password" => 'required|string|min:1|max:100'
        ];
    }
}
