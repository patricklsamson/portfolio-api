<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GetUserRequest extends BaseRequest implements RequestInterface
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

        self::fieldsData($data, [
            'addresses',
            'assets',
            'messages',
            'profiles',
            'users'
        ]);

        self::includeData($data);

        if ($request->path() != 'v1/users/profile') {
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
        $rules = array_merge(
            self::fieldsRule([
                'addresses',
                'assets',
                'messages',
                'profiles',
                'users'
            ]),
            self::includeRule([
                'address',
                'assets',
                'messages',
                'profiles'
            ])
        );

        if (App::make(Request::class)->path() != 'v1/users/profile') {
            $rules = array_merge(
                $rules,
                self::pageRule(),
                self::sortRule(array_merge(User::ATTRIBUTES, [
                    'created_at',
                    'updated_at'
                ]))
            );
        }

        return $rules;
    }
}
