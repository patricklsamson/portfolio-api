<?php

namespace App\Repositories\Interfaces;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

interface MessageRepositoryInterface
{
    public function getAll();
    public function getOne($id, $request);
}
