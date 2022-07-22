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
            Arr::set($data, "fields.$field", self::strToArray(
                Arr::get($data, "fields.$field")
            ));
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
            Arr::set($data, "filter.$attribute", self::strToArray(
                Arr::get($data, "filter.$attribute")
            ));
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
        Arr::set(
            $data,
            'include',
            self::strToArray(Arr::get($data, 'include'), [])
        );
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
        $sorts = self::strToArray(Arr::get($data, 'sort'), []);
        $formattedSorts = [];

        if (!empty($sorts)) {
            foreach ($sorts as $sort) {
                if ($sort[0] == '-') {
                    $formattedSorts[] = str_replace('-', '', $sort);
                    $formattedSorts[] = 'desc';
                } else {
                    $formattedSorts[] = $sort;
                    $formattedSorts[] = 'asc';
                }
            }
        }

        Arr::set($data, 'sort', $formattedSorts);
    }

    /**
     * Set fields allowed
     *
     * @param array $fieldsAllowed
     *
     * @return array
     */
    public function fieldsAllowed(array $fieldsAllowed): array
    {
        return [
            'fields' => self::strArrayConcat('nullable|array:', $fieldsAllowed)
        ];
    }

    /**
     * Set fields addresses rules
     *
     * @return array
     */
    public function fieldsAddressesRules(): array
    {
        return [
            'fields.addresses.*' => self::strArrayConcat(
                'required_with:fields.addresses|string|distinct|in:',
                Address::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields assets rules
     *
     * @return array
     */
    public function fieldsAssetsRules(): array
    {
        return [
            'fields.assets.*' => self::strArrayConcat(
                'required_with:fields.assets|string|distinct|in:',
                Asset::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields messages rules
     *
     * @return array
     */
    public function fieldsMessagesRules(): array
    {
        return [
            'fields.messages.*' => self::strArrayConcat(
                'required_with:fields.messages|string|distinct|in:',
                Message::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields profiles rules
     *
     * @return array
     */
    public function fieldsProfilesRules(): array
    {
        return [
            'fields.profiles.*' => self::strArrayConcat(
                'required_with:fields.profiles|string|distinct|in:',
                Profile::ATTRIBUTES
            )
        ];
    }

    /**
     * Set fields users rules
     *
     * @return array
     */
    public function fieldsUsersRules(): array
    {
        return [
            'fields.users.*' => self::strArrayConcat(
                'required_with:fields.users|string|distinct|in:',
                User::ATTRIBUTES
            )
        ];
    }

    public function filterRules(
        string $filterableAttribute,
        array $enumValues
    ): array {
        return [
            'filter' => "nullable|array:$filterableAttribute",
            "filter.$filterableAttribute.*" => self::strArrayConcat(
                "required_with:filter.$filterableAttribute|string|distinct|in:",
                $enumValues
            )
        ];
    }

    /**
     * Set include rules
     *
     * @param mixed $rule
     *
     * @return array
     */
    public function includeRules($rule): array
    {
        return [
            'include' => 'nullable|array',
            'include.*' => is_array($rule) ? self::strArrayConcat(
                'required_with:include|string|distinct|in:',
                $rule
            ) : $rule
        ];
    }

    /**
     * Set sort rules
     *
     * @param array $sortableAttributes
     *
     * @return array
     */
    public function sortRules(array $sortableAttributes): array
    {
        return [
            'sort' => 'nullable|array',
            'sort.*' => self::strArrayConcat(
                'nullable|string|in:asc,desc,',
                $sortableAttributes
            )
        ];
    }

    /**
     * Set data attributes rules
     *
     * @param array $attributes
     *
     * @return array
     */
    public function dataAttributesRules(array $attributes): array
    {
        return [
            'data' => 'required|array:attributes',
            'data.attributes' => self::strArrayConcat(
                'required|array:',
                $attributes
            )
        ];
    }
}
