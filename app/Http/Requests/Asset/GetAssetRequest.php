<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Asset;
use Illuminate\Http\Request;

class GetAssetRequest extends BaseRequest implements RequestInterface
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
        self::fieldsData($data, ['addresses', 'assets', 'profiles', 'users']);
        self::filterData($data, ['type']);
        self::includeData($data);
        self::sortData($data);

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
            self::fieldsAllowedRule([
                'addresses',
                'assets',
                'profiles',
                'users'
            ]),
            self::fieldsAssetsRule(),
            self::filterableAttributesRule(['type']),
            self::filterValuesRule('type', Asset::TYPES),
            self::includeRule(['profiles', 'address', 'users'])
        );
    }
}
