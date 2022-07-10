<?php

namespace App\Http\Requests\Interfaces;

interface RequestInterface
{
    public function data(): array;
    public function rules(): array;
}
