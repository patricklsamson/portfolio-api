<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Address;
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
        $relationships = 'data.relationships';

        return array_merge(
            self::dataAttributesRule(
                array_merge(User::ATTRIBUTES, ['password'])
            ),
            self::relationshipsRule(['address' => Address::ATTRIBUTES]),
            [
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
                    "required_with:$metadata.websites|string|distinct",
                "$relationships.address.$attributes.line_1" =>
                    "required_with:$relationships.address|string|min:1|max:255",
                "$relationships.address.$attributes.line_2" =>
                    'nullable|string|min:1|max:255',
                "$relationships.address.$attributes.district" =>
                    'nullable|string|min:1|max:50',
                "$relationships.address.$attributes.city" =>
                    "required_with:$relationships.address|string|min:1|max:50",
                "$relationships.address.$attributes.state" =>
                    'nullable|string|min:1|max:50',
                "$relationships.address.$attributes.country" =>
                    "required_with:$relationships.address|string|min:1|max:50",
                "$relationships.address.$attributes.zip_code" =>
                    'nullable|string|min:1|max:50'
            ]
        );
    }
}
