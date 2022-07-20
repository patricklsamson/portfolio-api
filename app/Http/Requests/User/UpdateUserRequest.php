<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\User;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;

class UpdateUserRequest extends Request implements RequestInterface
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
                array_merge(User::ATTRIBUTES, ['password'])
            ),
            "$attributes.name" => 'nullable|string|min:1|max:100',
            "$attributes.email" => 'nullable|string|min:1|max:50',
            "$attributes.username" => 'nullable|string|min:1|max:50',
            "$attributes.metadata" =>
                'nullable|array:about,contacts,objective,websites',
            "$attributes.metadata.about" => 'nullable|string|min:1',
            "$attributes.metadata.contacts" => 'nullable|array',
            "$attributes.metadata.contacts.*" => 'nullable|string|distinct',
            "$attributes.metadata.objective" =>
                "same:$attributes.metadata.about",
            "$attributes.metadata.websites" => 'nullable|array',
            "$attributes.metadata.websites.*" => 'nullable|string|distinct'
        ];
    }
}
