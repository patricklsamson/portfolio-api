<?php

namespace App\Traits;

trait DateTrait {
    /**
     * Determine if date is older
     *
     * @param mixed $olderDate
     * @param mixed $newerDate
     *
     * @return bool
     */
    public function isOlderDate($olderDate, $newerDate): bool
    {
        return strtotime($olderDate) < strtotime($newerDate);
    }

    /**
     * Determine if date is newer
     *
     * @param mixed $newerDate
     * @param mixed $olderDate
     *
     * @return bool
     */
    public function isNewerDate($newerDate, $olderDate): bool
    {
        return strtotime($newerDate) > strtotime($olderDate);
    }
}
