<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class CreateAssetRequest extends BaseRequest implements RequestInterface
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
        $data = $request->all();

        Arr::set($data, 'data.attributes.slug', strtolower(
            str_replace(' ', '-', Arr::get($data, 'data.attributes.name'))
        ));

        return $data;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        $data = App::make(Request::class)->all();
        $category = Arr::get($data, 'data.attributes.category');

        $dataAttributesRule = [
            'name' => 'required|string|unique:assets,name|min:1|max:100',
            'slug' => 'required|string|min:1|max:100',
            'category' => self::strArrayConcat(
                'required|string|in:',
                Asset::CATEGORIES
            )
        ];

        $metadata = 'data.attributes.metadata';

        if ($category == 'project') {
            $dataAttributesRule = array_merge(
                $dataAttributesRule,
                [
                    'metadata' => 'filled|array:project',
                    'metadata.project' => 'filled|array:dates,urls',
                    'metadata.project.dates' => 'filled|array:start,end',
                    'metadata.project.dates.start' => [
                        "required_with:$metadata.project.dates",
                        'string',
                        function ($attribute, $value, $fail) {
                            $endDate = Arr::get(
                                App::make(Request::class)->all(),
                                'data.attributes.metadata.project.dates.end'
                            );

                            if (
                                $endDate &&
                                self::isOlderDate($endDate, $value)
                            ) {
                                $fail("$attribute is invalid.");
                            }
                        }
                    ],
                    'metadata.project.dates.end' => [
                        'nullable',
                        'string',
                        function ($attribute, $value, $fail) {
                            $startDate = Arr::get(
                                App::make(Request::class)->all(),
                                'data.attributes.metadata.project.dates.start'
                            );

                            if (
                                $value &&
                                self::isOlderDate($value, $startDate)
                            ) {
                                $fail("$attribute is invalid.");
                            }
                        }
                    ],
                    'metadata.urls' => 'filled|array:code,live',
                    'metadata.urls.code' =>
                        "required_with:$metadata.urls|string",
                    'metadata.urls.live' => 'nullable|string'
                ]
            );
        }

        $rules = self::dataAttributesRule($dataAttributesRule);
        $address = 'data.relationships.address';

        if (
            $category != 'project' &&
            $category != 'soft_skill' &&
            $category != 'tech_skill'
        ) {
            $rules = array_merge(
                $rules,
                self::dataRelationshipsRule([
                    'address' => [
                        'line_1' =>
                            "required_with:$address|string|min:1|max:255",
                        'line_2' => 'nullable|string|min:1|max:255',
                        'district' => 'nullable|string|min:1|max:50',
                        'city' => "required_with:$address|string|min:1|max:50",
                        'state' => 'nullable|string|min:1|max:50',
                        'country' =>
                            "required_with:$address|string|min:1|max:50",
                        'zip_code' => 'nullable|string|min:1|max:50'
                    ]
                ])
            );
        }

        return $rules;
    }
}
