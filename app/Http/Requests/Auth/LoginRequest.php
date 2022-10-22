<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;

class LoginRequest extends BaseRequest implements RequestInterface
{
    /**
     * Get data to be validated from the request
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
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(
            self::dataAttributesRule([
                'username' => 'required|string|min:1|max:50',
                'password' => 'required|string|min:1|max:100'
            ]),
            self::fieldsRule(['users']),
            self::includeRule(['user'])
        );
    }
}
