<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use Illuminate\Http\Request;

class CreateMessageRequest extends BaseRequest implements RequestInterface
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
        return $request->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $attributes = 'data.attributes';

        return array_merge(
            self::dataAttributesRules(Message::ATTRIBUTES),
            [
                "$attributes.sender" => 'required|string|min:1|max:100',
                "$attributes.email" => 'required|string|min:1|max:50',
                "$attributes.body" => 'required|string|min:1',
                "$attributes.type" => 'required|string|in:inbox',
                "$attributes.user_id" => 'required|integer|min:1'
            ]
        );
    }
}
