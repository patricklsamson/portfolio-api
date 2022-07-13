<?php

namespace App\Http\Requests;

use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use App\Models\User;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GetMessageRequest extends Request implements RequestInterface
{
    use ArrayTrait;

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function data(Request $request): array
    {
        $data = $request->all();

        Arr::has($data, 'fields.messages') &&
            $data['fields']['messages'] = self::strToArray($data['fields']['messages']);

        Arr::has($data, 'fields.users') &&
            $data['fields']['users'] = self::strToArray($data['fields']['users']);

        Arr::has($data, 'filter.type') &&
            $data['filter']['type'] = self::strToArray($data['filter']['type']);

        Arr::has($data, 'include') &&
            $data['include'] = self::strToArray($data['include']);

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request): array
    {
        return [
            'fields.*' => 'required|array|in:messages,users',
            'fields.messages.*' => 'required|string|in:' . implode(',', Message::ATTRIBUTES),
            'fields.users.*' => 'required|string|in:' . implode(',', User::ATTRIBUTES),
            'filter.*' => 'required|array|in:type',
            'filter.type.*' => 'required|string|in:' . implode(',', Message::TYPES),
            'include.*' => 'required|string|in:user',
            'page.*' => 'required|array|in:number,size',
            'page.number' => 'required|integer|min:1',
            'page.size' => 'same:page.number',
            'sort.*' => 'required|array:created_at',
            'sort.created_at' => 'required|string|in:desc,asc'
        ];
    }
}
