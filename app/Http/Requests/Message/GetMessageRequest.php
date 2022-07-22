<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GetMessageRequest extends BaseRequest implements RequestInterface
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
        self::fieldsData($data, ['messages', 'users']);
        self::filterData($data, ['type']);
        self::includeData($data);

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
            self::fieldsAllowed(['messages', 'users']),
            self::fieldsMessagesRules(),
            self::fieldsUsersRules(),
            self::filterRules('type', Message::TYPES),
            self::includeRules(['user']),
            [
                'page' => 'nullable|array:number,size',
                'page.number' => 'nullable|integer|min:1',
                'page.size' => 'nullable|integer|min:1',
            ]
        );
    }
}
