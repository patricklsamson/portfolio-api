<?php

namespace App\Traits;

trait ArrayTrait
{
    /**
     * Sanitize and transform string to array
     *
     * @param string $string
     * @param bool $unique
     *
     * @return array
     */
    public function strToArray(string $string, bool $unique = true): array
    {
        $sanitizeString = str_replace(' ', '', $string);
        $toArray = explode(',', $sanitizeString);

        return $unique ? array_unique($toArray, SORT_REGULAR) : $toArray;
    }
}
