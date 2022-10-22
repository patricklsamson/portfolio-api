<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest extends BaseRequest implements RequestInterface
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
        return $request->all();
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        $attributes = 'data.attributes';
        $metadata = "$attributes.metadata";
        $relationships = 'data.relationships';
        $address = "$relationships.address";

        return array_merge(
            self::dataAttributesRule([
                'name' => 'nullable|string|min:1|max:100',
                'email' => 'nullable|string|min:1|max:50',
                'username' => 'nullable|string|min:1|max:50',
                'password' => 'nullable|string|confirmed|' .
                    "different:$attributes.password_old|min:1|max:100",
                'password_confirmation' => null,
                'password_old' => [
                    "required_with:$attributes.password",
                    'string',
                    'min:1',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (!Hash::check(
                            $value,
                            App::make(Request::class)->user()->password
                        )) {
                            $fail("$attribute is invalid.");
                        }
                    }
                ],
                'metadata' => 'filled|array:about,contacts,objective,websites',
                'metadata.about' => 'nullable|string|min:1',
                'metadata.contacts' => 'filled|array',
                'metadata.contacts.*' =>
                    "required_with:$metadata.contacts|string|distinct",
                'metadata.objective' => 'nullable|string|min:1',
                'metadata.websites' => 'filled|array',
                'metadata.websites.*' =>
                    "required_with:$metadata.websites|string|distinct"
            ], false),
            self::dataRelationshipsRule([
                'address' => [
                    'line_1' => "required_with:$address|string|min:1|max:255",
                    'line_2' => 'nullable|string|min:1|max:255',
                    'district' => 'nullable|string|min:1|max:50',
                    'city' => "required_with:$address|string|min:1|max:50",
                    'state' => 'nullable|string|min:1|max:50',
                    'country' => "required_with:$address|string|min:1|max:50",
                    'zip_code' => 'nullable|string|min:1|max:50'
                ]
            ])
        );
    }
}
