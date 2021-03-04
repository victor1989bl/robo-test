<?php

namespace App\Http\Controllers;

use App\Repositories\Abstracts\UserRepositoryInterface;
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

    public function index()
    {
        $users = $this->userService->getAllUsersWithInfo();

        return view('users/list', compact('users'));
    }
}
