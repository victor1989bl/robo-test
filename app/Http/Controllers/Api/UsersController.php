<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\User\UserCollection;
use App\Services\Abstracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * UsersController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function users()
    {
        return new UserCollection(
            $this->userService->getAllUsers()
        );
    }
}
