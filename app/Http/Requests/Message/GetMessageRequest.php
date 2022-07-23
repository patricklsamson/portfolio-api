<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use Illuminate\Http\Request;

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
            self::fieldsAllowedRule(['messages', 'users']),
            self::fieldsMessagesRule(),
            self::fieldsUsersRule(),
            self::filterableAttributesRule(['type']),
            self::filterValuesRule('type', Message::TYPES),
            self::includeRule(['user']),
            [
                'page' => 'nullable|array:number,size',
                'page.number' => 'nullable|integer|min:1',
                'page.size' => 'nullable|integer|min:1',
            ]
        );
    }
}
