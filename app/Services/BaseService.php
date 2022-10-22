<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Repositories\AssetRepository;
use App\Repositories\MessageRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;

class BaseService
{
    /**
     * Address repository
     *
     * @var AddressRepository
     */
    public $addressRepository;

    /**
     * Asset repository
     *
     * @var AssetRepository
     */
    public $assetRepository;

    /**
     * Message repository
     *
     * @var MessageRepository
     */
    public $messageRepository;

    /**
     * Profile repository
     *
     * @var ProfileRepository
     */
    public $profileRepository;

    /**
     * User repository
     *
     * @var UserRepository
     */
    public $userRepository;

    /**
     * Constructor
     *
     * @param AddressRepository $addressRepository
     * @param AssetRepository $assetRepository
     * @param MessageRepository $messageRepository
     * @param ProfileRepository $profileRepository
     * @param UserRepository $userRepository
     *
     * @return void
     */
    public function __construct(
        AddressRepository $addressRepository,
        AssetRepository $assetRepository,
        MessageRepository $messageRepository,
        ProfileRepository $profileRepository,
        UserRepository $userRepository
    ) {
        $this->addressRepository = $addressRepository;
        $this->assetRepository = $assetRepository;
        $this->messageRepository = $messageRepository;
        $this->profileRepository = $profileRepository;
        $this->userRepository = $userRepository;
    }
}
