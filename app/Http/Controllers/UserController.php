<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResourceTrait;

class UserController extends Controller
{
    use ResourceTrait;

    public function getAll()
    {
        return $this->resource(User::with('messages')->get());
    }

    public function getOne($id)
    {
        return $this->resource(User::with('messages')->find($id));
    }
}
