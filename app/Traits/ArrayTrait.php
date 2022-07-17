<?php

namespace App\Traits;

trait ArrayTrait
{
    /**
     * Sanitize and transform string to array
     *
     * @param ?string $string
     * @param mixed $return
     *
     * @return mixed
     */
    public function strToArray(?string $string, $return = null)
    {
        return $string ? explode(',', str_replace(' ', '', $string)) : $return;
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
