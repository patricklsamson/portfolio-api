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
        self::filterData($data, ['level', 'starred', 'category']);
        self::includeData($data);
        self::pageData($data);
        self::sortData($data);

        if (Arr::has($data, 'filter.starred')) {
            Arr::set($data, 'filter.starred.0', filter_var(
                Arr::get($data, 'filter.starred.0'),
                FILTER_VALIDATE_BOOLEAN
            ));
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
        return array_merge(
            self::fieldsRule(['assets', 'profiles', 'users']),
            self::filterRule([
                'level' => array_keys(Profile::LEVELS),
                'starred' => 'boolean|distinct',
                'category' => Profile::CATEGORIES
            ]),
            self::includeRule(['asset', 'user']),
            self::pageRule(),
            self::sortRule(array_merge(Profile::ATTRIBUTES, [
                'created_at',
                'updated_at'
            ]))
        );
    }
}
