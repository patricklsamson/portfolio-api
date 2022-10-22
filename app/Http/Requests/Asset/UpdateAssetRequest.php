<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Asset;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class UpdateAssetRequest extends BaseRequest implements RequestInterface
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

        if (Arr::has($data, 'data.attributes.name')) {
            Arr::set($data, 'data.attributes.slug', strtolower(
                str_replace(' ', '-', Arr::get($data, 'data.attributes.name'))
            ));
        }

        if (Arr::has($data, 'data.relationships.profiles')) {
            Arr::set(
                $data,
                'data.relationships.profiles.data.attributes.category',
                Asset::find($request->id)->category
            );
        }

        return $data;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        $category = Asset::find(App::make(Request::class)->id)->category;

        $dataAttributesRule = [
            'name' => 'nullable|string|unique:assets,name|min:1|max:100',
            'slug' => 'required_with:data.attributes.name|string|min:1|max:100',
        ];

        if ($category == 'project') {
            $dataAttributesRule = array_merge(
                $dataAttributesRule,
                [
                    'metadata' => 'filled|array:project',
                    'metadata.project' => 'filled|array:dates,urls',
                    'metadata.project.dates' => 'filled|array:start,end',
                    'metadata.project.dates.start' => [
                        'nullable',
                        'string',
                        function ($attribute, $value, $fail) {
                            $endDate = Arr::get(
                                App::make(Request::class)->all(),
                                'data.attributes.metadata.project.dates.end'
                            );

                            if (
                                strtolower($endDate) != 'present' &&
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
                                $value != 'present' &&
                                self::isOlderDate($value, $startDate)
                            ) {
                                $fail("$attribute is invalid.");
                            }
                        }
                    ],
                    'metadata.urls' => 'filled|array:code,live',
                    'metadata.urls.code' => 'nullable|string',
                    'metadata.urls.live' => 'nullable|string',
                ]
            );
        }

        $profileAttributes = [
            'category' => self::strArrayConcat(
                "required_with:data.relationships.profiles|string|in:",
                Profile::CATEGORIES
            ),
            'description' => 'nullable|string|min:1'
        ];

        if ($category == 'project') {
            $profileAttributes = array_merge(
                $profileAttributes,
                [
                    'starred' => 'nullable|boolean',
                    'metadata' => 'filled|array:project',
                    'metadata.project' => 'filled|array:role,contributions',
                    'metadata.project.role' =>
                        'nullable|string|in:contributor,owner',
                    'metadata.project.contributions' => 'filled|array',
                    'metadata.project.contributions.*' =>
                        'nullable|string|distinct'
                ]
            );
        }

        if ($category != 'project' && $category != 'soft_skill') {
            $profileAttributes = array_merge(
                $profileAttributes,
                [
                    'start_date' => [
                        'nullable',
                        'string',
                        function ($attribute, $value, $fail) {
                            $endDate = Arr::get(
                                App::make(Request::class)->all(),
                                'data.relationships.profiles.' .
                                    'data.attributes.start_date'
                            );

                            if (
                                $value &&
                                $endDate &&
                                self::isOlderDate($value, $endDate)
                            ) {
                                $fail("$attribute is invalid.");
                            }
                        }
                    ],
                    'end_date' => [
                        'nullable',
                        'string',
                        function ($attribute, $value, $fail) {
                            $startDate = Arr::get(
                                App::make(Request::class)->all(),
                                'data.attributes.metadata.project.dates.start'
                            );

                            if (
                                $startDate &&
                                $value &&
                                self::isOlderDate($startDate, $value)
                            ) {
                                $fail("$attribute is invalid.");
                            }
                        }
                    ]
                ]
            );
        }

        if ($category == 'tech_skill') {
            $profileAttributes = array_merge(
                $profileAttributes,
                [
                    'level' => self::strArrayConcat(
                        'nullable|string|in:',
                        array_keys(Profile::LEVELS)
                    )
                ]
            );
        }

        $dataRelationshipsRule = ['profiles' => $profileAttributes];
        $address = 'data.relationships.address';

        if (
            $category != 'project' &&
            $category != 'soft_skill' &&
            $category != 'tech_skill'
        ) {
            $dataRelationshipsRule = array_merge(
                $dataRelationshipsRule,
                [
                    'address' => [
                        'line_1' =>
                            "required_with:$address|string|min:1|max:255",
                        'line_2' => 'nullable|string|min:1|max:255',
                        'district' => 'nullable|string|min:1|max:50',
                        'city' => "required_with:$address|string|min:1|max:50",
                        'state' => 'nullable|string|min:1|max:50',
                        'country' =>
                            "required_with:$address|string|min:1|max:50",
                        'zip_code' => 'nullable|string|min:1|max:50',
                    ]
                ]
            );
        }

        $rules = array_merge(
            self::dataAttributesRule($dataAttributesRule, false),
            self::dataRelationshipsRule($dataRelationshipsRule)
        );

        return $rules;
    }
}
