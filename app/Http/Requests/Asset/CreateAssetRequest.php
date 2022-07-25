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

        Arr::set(
            $data,
            'data.attributes.slug',
            str_replace(' ', '-', strtolower(
                Arr::get($data, 'data.attributes.name')
            ))
        );

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

        return array_merge(
            self::dataAttributesRule(Asset::ATTRIBUTES),
            [
                "$attributes.name" => 'required|string|min:1|max:100',
                "$attributes.slug" => 'required|string|min:1|max:100',
                "$attributes.type" => self::strArrayConcat(
                    'required|string|in:',
                    Asset::TYPES
                ),
                $metadata => 'filled|array',
                "$metadata.project" => 'filled|array:dates,urls',
                "$metadata.project.dates" => 'filled|array:start,end',
                "$metadata.project.dates.start" =>
                    "required_with:$metadata.project.dates|string",
                "$metadata.project.dates.end" => 'nullable|string',
                "$metadata.urls" => 'filled|array:code,live',
                "$metadata.urls.code" => "required_with:$metadata.urls|string",
                "$metadata.urls.live" => 'nullable|string'

            ]
        );
    }
}
