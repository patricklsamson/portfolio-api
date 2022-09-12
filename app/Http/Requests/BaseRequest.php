<?php

namespace App\Http\Requests;

use App\Models\Address;
use App\Models\Asset;
use App\Models\Message;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ArrayTrait;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BaseRequest extends Request
{
    use ArrayTrait;
    use DateTrait;

    /**
     * Set fields data
     *
     * @param array &$data
     * @param array $fields
     *
     * @return void
     */
    public function fieldsData(array &$data, array $fields): void
    {
        foreach ($fields as $field) {
            if (Arr::has($data, "fields.$field")) {
                Arr::set($data, "fields.$field", self::strToArray(
                    Arr::get($data, "fields.$field")
                ));
            }
        }
    }

    /**
     * Set filter data
     *
     * @param array &$data
     * @param array $filterableAttributes
     *
     * @return void
     */
    public function filterData(
        array &$data,
        array $filterableAttributes
    ): void {
        foreach ($filterableAttributes as $attribute) {
            if (Arr::has($data, "filter.$attribute")) {
                Arr::set($data, "filter.$attribute", self::strToArray(
                    Arr::get($data, "filter.$attribute")
                ));
            }
        }
    }

    /**
     * Set include data
     *
     * @param array &$data
     *
     * @return void
     */
    public function includeData(array &$data): void
    {
        if (Arr::has($data, 'include')) {
            Arr::set(
                $data,
                'include',
                self::strToArray(Arr::get($data, 'include'))
            );
        }
    }

    /**
     * Set page data
     *
     * @param array &$data
     *
     * @return void
     */
    public function pageData(array &$data): void
    {
        if (Arr::has($data, 'cursor')) {
            Arr::set($data, 'cursor', filter_var(
                Arr::get($data, 'cursor'),
                FILTER_VALIDATE_BOOLEAN
            ));
        }
    }

    /**
     * Set sort data
     *
     * @param array &$data
     * @param array $defaultSorts
     *
     * @return void
     */
    public function sortData(array &$data, array $defaultSorts = []): void
    {
        if (count($defaultSorts) > 0 || Arr::has($data, 'sort')) {
            $sorts = self::strToArray(Arr::get($data, 'sort'), []);
            $sorts = array_merge($sorts, $defaultSorts);
            $formattedSorts = [];

            foreach ($sorts as $sort) {
                if ($sort[0] == '-') {
                    $formattedSorts[] = str_replace('-', '', $sort);
                    $formattedSorts[] = 'desc';
                } else {
                    $formattedSorts[] = $sort;
                    $formattedSorts[] = 'asc';
                }
            }

            Arr::set($data, 'sort', $formattedSorts);
        }
    }

    /**
     * Set fields addresses rule
     *
     * @return array
     */
    public function fieldsAddressesRule(): array
    {
        return [
            'fields.addresses' => 'filled|array',
            'fields.addresses.*' => self::strArrayConcat(
                'required_with:fields.addresses|string|distinct|in:',
                Address::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields assets rule
     *
     * @return array
     */
    public function fieldsAssetsRule(): array
    {
        return [
            'fields.assets' => 'filled|array',
            'fields.assets.*' => self::strArrayConcat(
                'required_with:fields.assets|string|distinct|in:',
                Asset::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields messages rule
     *
     * @return array
     */
    public function fieldsMessagesRule(): array
    {
        return [
            'fields.messages' => 'filled|array',
            'fields.messages.*' => self::strArrayConcat(
                'required_with:fields.messages|string|distinct|in:',
                Message::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields profiles rule
     *
     * @return array
     */
    public function fieldsProfilesRule(): array
    {
        return [
            'fields.profiles' => 'filled|array',
            'fields.profiles.*' => self::strArrayConcat(
                'required_with:fields.profiles|string|distinct|in:',
                Profile::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields users rule
     *
     * @return array
     */
    public function fieldsUsersRule(): array
    {
        return [
            'fields.users' => 'filled|array',
            'fields.users.*' => self::strArrayConcat(
                'required_with:fields.users|string|distinct|in:',
                User::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields allowed rule
     *
     * @param array $fields
     *
     * @return array
     */
    public function fieldsRule(array $fields): array
    {
        $rules = [
            'fields' => self::strArrayConcat('filled|array:', $fields)
        ];

        foreach ($fields as $field) {
            switch ($field) {
                case 'addresses':
                    $rules = array_merge($rules, self::fieldsAddressesRule());

                    break;
                case 'assets':
                    $rules = array_merge($rules, self::fieldsAssetsRule());

                    break;
                case 'messages':
                    $rules = array_merge($rules, self::fieldsMessagesRule());

                    break;
                case 'profiles':
                    $rules = array_merge($rules, self::fieldsProfilesRule());

                    break;
                case 'users':
                    $rules = array_merge($rules, self::fieldsUsersRule());

                    break;
                default:
                    return $rules;
            }
        }

        return $rules;
    }

    /**
     * Set filterable attributes rule
     *
     * @param array $filterRulesMap
     *
     * @return array
     */
    public function filterRule(
        array $filterRulesMap
    ): array {
        $rules = [
            'filter' => self::strArrayConcat(
                'filled|array:',
                array_keys($filterRulesMap)
            )
        ];

        foreach ($filterRulesMap as $attribute => $rule) {
            $rules = array_merge($rules, [
                "filter.$attribute" => 'filled|array',
                "filter.$attribute.*" => "required_with:filter.$attribute|" .
                    (is_array($rule) ? self::strArrayConcat(
                        'string|distinct|in:',
                        $rule
                    ) : $rule)
            ]);
        }

        return $rules;
    }

    /**
     * Set include rule
     *
     * @param mixed $rule
     *
     * @return array
     */
    public function includeRule($rule): array
    {
        return [
            'include' => 'filled|array',
            'include.*' => 'required_with:include|' .
                (is_array($rule) ? self::strArrayConcat(
                    'string|distinct|in:',
                    $rule
                ) : $rule)
        ];
    }

    /**
     * Set page rule
     *
     * @return array
     */
    public function pageRule(): array
    {
        return [
            'page' => 'filled|array:cursor,number,size',
            'page.size' => 'filled|integer|min:1',
            'page.number' =>
                'filled|integer|prohibits:cursor,page.cursor|min:1',
            'cursor' =>
                'required_with:page.cursor|boolean|prohibits:page.number',
            'page.cursor' => 'filled|string|prohibits:page.number|min:1'
        ];
    }

    /**
     * Set sort rule
     *
     * @param array $sortableAttributes
     *
     * @return array
     */
    public function sortRule(array $sortableAttributes): array
    {
        return [
            'sort' => 'filled|array',
            'sort.*' => self::strArrayConcat(
                'required_with:sort|string|in:asc,desc,created_at,',
                $sortableAttributes
            )
        ];
    }

    /**
     * Set data attributes rule
     *
     * @param array $attributesMap
     * @param bool $required
     *
     * @return array
     */
    public function dataAttributesRule(
        array $attributesMap,
        bool $required = true
    ): array {
        $rules = [
            'data' => 'required|array:attributes',
            'data.attributes' => self::strArrayConcat(
                ($required ? 'required' : 'filled') . '|array:',
                array_filter(array_map(function ($attribute) {
                    return !strpos($attribute, '.') ? $attribute : null;
                }, array_keys($attributesMap)))
            )
        ];

        foreach ($attributesMap as $attribute => $rule) {
            if (!$rule) {
                continue;
            }

            $rules = array_merge($rules, [
                "data.attributes.$attribute" => $rule
            ]);
        }

        return $rules;
    }

    /**
     * Set data relationships rule
     *
     * @param array $relationshipsMap
     *
     * @return array
     */
    public function dataRelationshipsRule(array $relationshipsMap): array
    {
        $data = 'data.relationships';

        $rules = [
            'data' => 'filled|array:attributes,relationships',
            $data => self::strArrayConcat(
                'filled|array:',
                array_keys($relationshipsMap)
            )
        ];

        foreach ($relationshipsMap as $relationship => $attributesMap) {
            $rules = array_merge(
                $rules,
                [
                    "$data.$relationship" => "required_with:$data|array:data",
                    "$data.$relationship.data" =>
                        "required_with:$data.$relationship|array:attributes",
                    "$data.$relationship.data.attributes" =>
                        self::strArrayConcat(
                            "required_with:$data.$relationship.data|array:",
                            array_filter(array_map(function ($attribute) {
                                return !strpos($attribute, '.') ?
                                    $attribute : null;
                            }, array_keys($attributesMap)))
                        )
                ]
            );

            foreach ($attributesMap as $attribute => $rule) {
                $rules = array_merge($rules, [
                    "$data.$relationship.data.attributes.$attribute" => $rule
                ]);
            }
        }

        return $rules;
    }
}
