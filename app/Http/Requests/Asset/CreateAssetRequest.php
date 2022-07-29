<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CreateAssetRequest extends BaseRequest implements RequestInterface
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

        Arr::set($data, 'data.attributes.slug', strtolower(
            str_replace(' ', '-', Arr::get($data, 'data.attributes.name'))
        ));

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $metadata = 'data.attributes.metadata';
        $relationships = 'data.relationships';
        $address = "$relationships.address";

        return array_merge(
            self::dataAttributesRule([
                'name' => 'required|string|min:1|max:100',
                'slug' => 'required|string|min:1|max:100',
                'type' => self::strArrayConcat(
                    'required|string|in:',
                    Asset::TYPES
                ),
                'metadata' => 'filled|array:project',
                'metadata.project' => 'filled|array:dates,urls',
                'metadata.project.dates' => 'filled|array:start,end',
                'metadata.project.dates.start' =>
                    "required_with:$metadata.project.dates|string",
                'metadata.project.dates.end' => 'nullable|string',
                'metadata.urls' => 'filled|array:code,live',
                'metadata.urls.code' => "required_with:$metadata.urls|string",
                'metadata.urls.live' => 'nullable|string'
            ]),
            self::relationshipsRule([
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
