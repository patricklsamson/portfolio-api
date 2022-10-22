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
     * Get data to be validated from the request
     *
     * @param Request $request
     *
     * @return array
     */
    public function data(Request $request): array
    {
        $data = $request->all();

        self::fieldsData($data, ['messages', 'users']);
        self::includeData($data);

        if ($request->path() == 'v1/messages') {
            self::filterData($data, ['category']);
            self::pageData($data);
            self::sortData($data, ['-created_at']);
        }

        return $data;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = array_merge(
            self::fieldsRule(['messages', 'users']),
            self::includeRule(['user'])
        );

        if (App::make(Request::class)->path() == 'v1/messages') {
            $rules = array_merge(
                $rules,
                self::filterRule(['category' => Message::CATEGORIES]),
                self::pageRule(),
                self::sortRule(array_merge(Message::ATTRIBUTES, [
                    'created_at',
                    'updated_at'
                ]))
            );
        }

        return $rules;
    }
}
