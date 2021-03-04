<?php

namespace App\Services;

use App\Repositories\Abstracts\UserRepositoryInterface;
use App\Services\Abstracts\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function getAllUsersWithInfo()
    {
        return $this->userRepository
            ->all()
            ->load([
                'metadata',
                'latestPayment',
                'latestPayment.recipient',
            ]);
    }
}
