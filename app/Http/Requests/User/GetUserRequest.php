<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use App\Models\User;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GetUserRequest extends Request implements RequestInterface
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
        Arr::set($data, 'fields.messages', self::strToArray(Arr::get($data, 'fields.messages')));
        Arr::set($data, 'fields.users', self::strToArray(Arr::get($data, 'fields.users')));
        Arr::set($data, 'include', self::strToArray(Arr::get($data, 'include'), []));
        Arr::set($data, 'sort.created_at', Arr::get($data, 'sort.created_at'));

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
            'fields' => 'nullable|array:messages,users',
            'fields.messages.*' => self::strArrayConcat(
                'nullable|string|distinct|in:',
                Message::ATTRIBUTES
            ),
            'fields.users.*' => self::strArrayConcat(
                'nullable|string|distinct|in:',
                User::ATTRIBUTES
            ),
            'include' => 'nullable|array',
            'include.*' => 'nullable|string|distinct|in:messages',
            'page' => 'nullable|array:number,size',
            'page.number' => 'nullable|integer|min:1',
            'page.size' => 'same:page.number',
            'sort' => 'nullable|array:created_at',
            'sort.created_at' => 'nullable|string|in:desc,asc'
        ];
    }
}
