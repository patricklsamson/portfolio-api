<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Address;
use App\Models\Asset;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UpdateAssetRequest extends BaseRequest implements RequestInterface
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

        if (Arr::has($data, 'data.attributes.name')) {
            Arr::set(
                $data,
                'data.attributes.slug',
                str_replace(' ', '-', strtolower(
                    Arr::get($data, 'data.attributes.name')
                ))
            );
        }

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
        $metadata = "$attributes.metadata";
        $relationships = 'data.relationships';
        $profilesMetadata = "$relationships.profiles.$attributes.metadata";

        return array_merge(
            self::dataAttributesRule(Asset::ATTRIBUTES, false),
            self::relationshipsRule(['address' => Address::ATTRIBUTES]),
            [
                "$attributes.name" => 'nullable|string|min:1|max:100',
                "$attributes.slug" => 'nullable|string|min:1|max:100',
                "$attributes.type" => self::strArrayConcat(
                    'nullable|string|in:',
                    Asset::TYPES
                ),
                $metadata => 'filled|array:project',
                "$metadata.project" => 'filled|array:dates,urls',
                "$metadata.project.dates" => 'filled|array:start,end',
                "$metadata.project.dates.start" => 'nullable|string',
                "$metadata.project.dates.end" => 'nullable|string',
                "$metadata.urls" => 'filled|array:code,live',
                "$metadata.urls.code" => 'nullable|string',
                "$metadata.urls.live" => 'nullable|string',
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
                    'nullable|string|min:1|max:50',
                "$relationships.profiles.$attributes.type" =>
                    self::strArrayConcat(
                        "required_with:$relationships.profiles|string|in:",
                        Profile::TYPES
                    ),
                "$relationships.profiles.$attributes.description" =>
                    'nullable|string|min:1',
                "$relationships.profiles.$attributes.level" =>
                    self::strArrayConcat(
                        'nullable|string|in:',
                        Profile::LEVELS
                    ),
                "$relationships.profiles.$attributes.starred" =>
                    'nullable|boolean',
                "$relationships.profiles.$attributes.start_date" =>
                    'nullable|date',
                "$relationships.profiles.$attributes.end_date" =>
                    'nullable|date',
                $profilesMetadata => 'filled|array:project',
                "$profilesMetadata.project" =>
                    'filled|array:role,contributions',
                "$profilesMetadata.project.role" =>
                    'nullable|string|in:contributor,owner',
                "$profilesMetadata.project.contributions" =>
                    'filled|array',
                "$profilesMetadata.project.contributions.*" =>
                    'nullable|string|distinct'
            ]
        );
    }
}
