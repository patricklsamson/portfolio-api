<?php

namespace App\Http\Requests;

use App\Models\Address;
use App\Models\Asset;
use App\Models\Message;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BaseRequest extends Request
{
    use ArrayTrait;

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
     * Set sort data
     *
     * @param array &$data
     *
     * @return void
     */
    public function sortData(array &$data): void
    {
        if (Arr::has($data, 'sort')) {
            $sorts = self::strToArray(Arr::get($data, 'sort'));
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
     * Set fields allowed rule
     *
     * @param array $fieldsAllowed
     *
     * @return array
     */
    public function fieldsAllowedRule(array $fieldsAllowed): array
    {
        return [
            'fields' => self::strArrayConcat('filled|array:', $fieldsAllowed)
        ];
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
     * Set filterable attributes rule
     *
     * @param array $filterableAttributes
     *
     * @return array
     */
    public function filterableAttributesRule(array $filterableAttributes): array
    {
        return [
            'filter' => self::strArrayConcat(
                'filled|array:',
                $filterableAttributes
            )
        ];
    }

    /**
     * Set filter values rule
     *
     * @return array
     */
    public function filterValuesRule(
        string $filterableAttribute,
        array $enumValues
    ): array {
        return [
            "filter.$filterableAttribute" => 'filled|array',
            "filter.$filterableAttribute.*" => self::strArrayConcat(
                "required_with:filter.$filterableAttribute|string|distinct|in:",
                $enumValues
            )
        ];
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
            'include.*' => is_array($rule) ? self::strArrayConcat(
                'required_with:include|string|distinct|in:',
                $rule
            ) : "required_with:include|$rule"
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
            'page.cursor' => 'filled|integer|min:1',
            'page.number' => 'filled|integer|min:1',
            'page.size' => 'filled|integer|min:1'
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
     * @param array $attributes
     *
     * @return array
     */
    public function dataAttributesRule(array $attributes): array
    {
        return [
            'data' => 'required|array:attributes',
            'data.attributes' => self::strArrayConcat(
                'required|array:',
                $attributes
            )
        ];
    }

    /**
     * Set relationships rule
     *
     * @param array $relationshipsMap
     *
     * @return array
     */
    public function relationshipsRule(array $relationshipsMap): array
    {
        $data = 'data.relationships';

        $rule = [
            $data => self::strArrayConcat(
                'filled|array:',
                array_keys($relationshipsMap)
            )
        ];

        foreach ($relationshipsMap as $relationship => $attributes) {
            Arr::set(
                $rule,
                "$data.$relationship",
                "required_with:$data|array:data"
            );

            Arr::set(
                $rule,
                "$data.$relationship.data",
                "required_with:$data.$relationship.data|array:attributes"
            );

            Arr::set(
                $rule,
                "$data.$relationship.data.attributes",
                self::strArrayConcat(
                    "required_with:$data.$relationship.data|array:",
                    $attributes
                )
            );
        }

        return $rule;
    }
}
