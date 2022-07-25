<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UpdateUserRequest extends BaseRequest implements RequestInterface
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
        $metadata = "$attributes.metadata";

        return array_merge(
            self::dataAttributesRule(
                array_merge(User::ATTRIBUTES, ['password'])
            ), [
                "$attributes.name" => 'nullable|string|min:1|max:100',
                "$attributes.email" => 'nullable|string|min:1|max:50',
                "$attributes.username" => 'nullable|string|min:1|max:50',
                "$attributes.password" =>
                    'nullable|string|confirmed|min:1|max:100',
                $metadata => 'filled|array:about,contacts,objective,websites',
                "$metadata.about" => 'nullable|string|min:1',
                "$metadata.contacts" => 'filled|array',
                "$metadata.contacts.*" =>
                    "required_with:$metadata.contacts|string|distinct",
                "$metadata.objective" => 'nullable|string|min:1',
                "$metadata.websites" => 'filled|array',
                "$metadata.websites.*" =>
                    "required_with:$metadata.websites|string|distinct"
            ]
        );
    }
}
