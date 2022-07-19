<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\Interfaces\RequestInterface;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DeleteMessageRequest extends Request implements RequestInterface
{
    use ArrayTrait;

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
        Arr::set($data, 'ids', self::strToArray(Arr::get($data, 'ids'), []));

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ids' => 'nullable|array',
            'ids.*' => 'nullable|integer|min:1'
        ];
    }
}
