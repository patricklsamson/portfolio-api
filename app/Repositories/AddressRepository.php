<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository extends BaseRepository
{
    /**
     * Constructor
     *
     * @param Address $address
     *
     * @return void
     */
    public function __construct(Address $address)
    {
        parent::__construct($address);
    }
}
