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

        self::fieldsData($data, ['users']);
        self::includeData($data);

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
            self::dataAttributesRule(['username', 'password']),
            self::fieldsRule(['users']),
            self::includeRule(['user']),
            [
                "$attributes.username" => 'required|string|min:1|max:50',
                "$attributes.password" => 'required|string|min:1|max:100'
            ]
        );
    }
}
