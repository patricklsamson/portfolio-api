<?php

namespace App\Traits;

trait ArrayTrait
{
    /**
     * Sanitize and transform string to array
     *
     * @param ?string $string
     *
     * @return mixed
     */
    public function strToArray(?string $string)
    {
        return $string ? explode(',', str_replace(' ', '', $string)) : null;
    }

    /**
     * Turn array to concatenated string
     *
     * @param string $string
     * @param array $array
     *
     * @return string
     */
    public function strArrayConcat(string $string, array $array): string
    {
        return $string . implode(',', $array);
    }
}
