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
            Arr::set($data, 'data.attributes.slug', strtolower(
                str_replace(' ', '-', Arr::get($data, 'data.attributes.name'))
            ));
        }

        if (Arr::has($data, 'data.relationships.profile')) {
            Arr::set(
                $data,
                'data.relationships.profile.type',
                Asset::find($request->id)->type
            );
        }
        dd($data);

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = App::make(Request::class)->all();
        $type = Arr::get($data, 'data.attributes.type');

        $dataAttributesRule = [
            'name' => 'nullable|string|unique:assets,name|min:1|max:100',
            'slug' => 'required_with:data.attributes.name|string|min:1|max:100',
        ];

        if ($type == 'project') {
            $dataAttributesRule = array_merge(
                $dataAttributesRule,
                [
                    'metadata' => 'filled|array:project',
                    'metadata.project' => 'filled|array:dates,urls',
                    'metadata.project.dates' => 'filled|array:start,end',
                    'metadata.project.dates.start' => 'nullable|string',
                    'metadata.project.dates.end' => 'nullable|string',
                    'metadata.urls' => 'filled|array:code,live',
                    'metadata.urls.code' => 'nullable|string',
                    'metadata.urls.live' => 'nullable|string',
                ]
            );
        }

        $relationships = 'data.relationships';
        $profiles = "$relationships.profiles";

        $dataRelationshipsRule = [
            'profiles' => [
                'type' => self::strArrayConcat(
                    "required_with:$profiles|string|in:",
                    Profile::TYPES
                ),
                'description' => 'nullable|string|min:1',
                'level' => self::strArrayConcat(
                    'nullable|string|in:',
                    array_keys(Profile::LEVELS)
                ),
                'starred' => 'nullable|boolean',
                'start_date' => 'nullable|string',
                'end_date' => 'nullable|string',
                'metadata' => 'filled|array:project',
                'metadata.project' => 'filled|array:role,contributions',
                'metadata.project.role' =>
                    'nullable|string|in:contributor,owner',
                'metadata.project.contributions' => 'filled|array',
                'metadata.project.contributions.*' =>
                    'nullable|string|distinct'
            ]
        ];

        $address = "$relationships.address";

        if (
            $type != 'project' &&
            $type != 'soft_skill' &&
            $type != 'tech_skill'
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

        $rules = [
            self::dataAttributesRule($dataAttributesRule, false),
            self::dataRelationshipsRule($dataRelationshipsRule)
        ];

        return $rules;
    }
}
