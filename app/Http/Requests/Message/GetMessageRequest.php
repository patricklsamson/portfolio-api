<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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

        self::includeData($data);

        if ($request->path() == 'v1/messages') {
            self::fieldsData($data, ['messages', 'users']);
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
        $rules = [self::includeRule(['user'])];

        if (App::make(Request::class)->path() == 'v1/messages') {
            $rules = array_merge(
                $rules,
                self::fieldsRule(['messages', 'users']),
                self::filterRule(['type' => Message::TYPES]),
                self::pageRule(),
                self::sortRule(Message::ATTRIBUTES)
            );
        }

        return $rules;
    }
}
