<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Message;
use App\Traits\ArrayTrait;
use Illuminate\Http\Request;

class CreateMessageRequest extends Request implements RequestInterface
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

        return [
            'data' => 'required|array:attributes',
            $attributes => self::strArrayConcat(
                'required|array:',
                Message::ATTRIBUTES
            ),
            "$attributes.sender" => 'required|string|min:1|max:100',
            "$attributes.email" => 'required|string|min:1|max:50',
            "$attributes.body" => 'required|string|min:1',
            "$attributes.type" => self::strArrayConcat(
                'required|string|in:',
                Message::TYPES
            ),
            "$attributes.user_id" => 'required|integer|min:1'
        ];
    }
}
