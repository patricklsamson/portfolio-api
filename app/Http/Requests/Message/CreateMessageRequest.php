<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use Illuminate\Http\Request;

class CreateMessageRequest extends BaseRequest implements RequestInterface
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
        return $request->all();
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        return self::dataAttributesRule([
            'sender' => 'required|string|min:1|max:100',
            'email' => 'required|string|min:1|max:50',
            'body' => 'required|string|min:1|max:50',
            'category' => 'required|string|in:inbox',
            'user_id' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    if (!Message::find($value)) {
                        $fail("$attribute is invalid.");
                    }
                }
            ]
        ]);
    }
}
