<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Interfaces\RequestInterface;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LoginRequest extends Request implements RequestInterface
{
    use ArrayTrait;

    /**
     * Get data to be validated from the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function data(Request $request): array
    {
        $data = $request->all();
        Arr::set($data, 'include', Arr::get($data, 'include'));

        return $data;
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
            $attributes => 'required|array:username,password',
            "$attributes.username" => 'required|string|min:1|max:50',
            "$attributes.password" => 'required|string|min:1|max:100'
        ];
    }
}
