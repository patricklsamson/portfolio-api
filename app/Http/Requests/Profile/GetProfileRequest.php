<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GetProfileRequest extends BaseRequest implements RequestInterface
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

        self::fieldsData($data, ['assets', 'profiles', 'users']);
        self::filterData($data, ['level', 'starred', 'type']);
        self::includeData($data);
        self::pageData($data);
        self::sortData($data);

        Arr::set($data, 'filter.starred', self::strToArray(filter_var(
            Arr::get($data, 'filter.starred'),
            FILTER_VALIDATE_BOOLEAN
        )));

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(
            self::fieldsRule(['assets', 'profiles', 'users']),
            self::filterRule([
                'level' => Profile::LEVELS,
                'starred' => 'boolean|distinct',
                'type' => Profile::TYPES
            ]),
            self::includeRule(['asset', 'user']),
            self::sortRule(Profile::ATTRIBUTES),
            self::pageRule()
        );
    }
}
