<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Interfaces\RequestInterface;
use App\Models\Address;
use App\Models\Asset;
use App\Models\Message;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

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
        self::fieldsData($data, ['messages', 'users']);
        self::includeData($data);
        self::sortData($data);

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
            self::fieldsAllowed([
                'addresses',
                'assets',
                'messages',
                'profiles',
                'users'
            ]),
            self::fieldsAddressesRules(),
            self::fieldsAssetsRules(),
            self::fieldsMessagesRules(),
            self::fieldsProfilesRules(),
            self::fieldsUsersRules(),
            self::includeRules([
                'address',
                'assets',
                'messages',
                'profiles'
            ]),
            self::sortRules(User::ATTRIBUTES),
            [
                'page' => 'nullable|array:number,size',
                'page.number' => 'nullable|integer|min:1',
                'page.size' => 'nullable|integer|min:1'
            ]
        );
    }
}
