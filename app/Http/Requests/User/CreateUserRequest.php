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
        $attributes = 'data.attributes';

        return array_merge(
            self::dataAttributesRule([
                'name',
                'email',
                'username',
                'password',
                'password_confirmation'
            ]), [
                "$attributes.name" => 'required|string|min:1|max:100',
                "$attributes.email" => 'required|string|min:1|max:50',
                "$attributes.username" => 'required|string|min:1|max:50',
                "$attributes.password" =>
                    'required|string|confirmed|min:1|max:100'
            ]
        );
    }
}
