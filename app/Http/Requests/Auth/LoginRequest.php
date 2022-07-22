<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LoginRequest extends BaseRequest implements RequestInterface
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

        return array_merge(
            self::dataAttributesRules(['username', 'password']),
            self::includeRules(['user']),
            [
                "$attributes.username" => 'required|string|min:1|max:50',
                "$attributes.password" => 'required|string|min:1|max:100'
            ]
        );
    }
}
