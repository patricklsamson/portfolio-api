<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Http\Request;

class DeleteAssetRequest extends BaseRequest implements RequestInterface
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

        self::includeData($data);

        return $data;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        return self::includeRule('integer|min:1');
    }
}
