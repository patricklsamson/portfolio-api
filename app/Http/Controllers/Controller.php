<?php

namespace App\Http\Controllers;

use App\Services\AssetService;
use App\Services\AuthService;
use App\Services\MessageService;
use App\Services\ProfileService;
use App\Services\UserService;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Asset service
     *
     * @var AssetService
     */
    public $assetService;

    /**
     * Auth service
     *
     * @var AuthService
     */
    public $authService;

    /**
     * Message service
     *
     * @var MessageService
     */
    public $messageService;

    /**
     * Profile service
     *
     * @var ProfileService
     */
    public $profileService;

    /**
     * User service
     *
     * @var UserService
     */
    public $userService;

    /**
     * Constructor
     *
     * @param AssetService $assetService
     * @param AuthService $authService
     * @param MessageService $messageService
     * @param ProfileService $profileService
     * @param UserService $userService
     *
     * @return void
     */
    public function __construct(
        AssetService $assetService,
        AuthService $authService,
        MessageService $messageService,
        ProfileService $profileService,
        UserService $userService
    ) {
        $this->assetService = $assetService;
        $this->authService = $authService;
        $this->messageService = $messageService;
        $this->profileService = $profileService;
        $this->userService = $userService;
    }
}
