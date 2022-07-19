<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\User;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;

class CreateUserRequest extends Request implements RequestInterface
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
            $attributes => self::strArrayConcat(
                'required|array:',
                User::ATTRIBUTES
            ),
            "$attributes.email" => 'required|string|min:1|max:50',
            "$attributes.username" => 'required|string|min:1|max:50',
            "$attributes.password" => 'required|string|min:1|max:100',
            "$attributes.password_confirmation" => "same:$attributes.password"
        ];
    }
}
