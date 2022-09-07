<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
        self::includeData($data);

        if ($request->path() == 'v1/assets') {
            self::filterData($data, ['type']);
            self::pageData($data);
            self::sortData($data);
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
        $rules = array_merge(
            self::fieldsRule(['addresses', 'assets', 'profiles', 'users']),
            self::includeRule(['address', 'profiles', 'users'])
        );

        if (App::make(Request::class)->path() == 'v1/assets') {
            $rules = array_merge(
                $rules,
                self::filterRule(['type' => Asset::TYPES]),
                self::pageRule(),
                self::sortRule(Asset::ATTRIBUTES)
            );
        }

        return $rules;
    }
}
