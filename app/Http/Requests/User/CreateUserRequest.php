<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;

class CreateUserRequest extends BaseRequest implements RequestInterface
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
        return self::dataAttributesRule([
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|string|min:1|max:50',
            'username' => 'required|string|min:1|max:50',
            'password' => 'required|string|confirmed|min:1|max:100',
            'password_confirmation' => null
        ]);
    }
}
