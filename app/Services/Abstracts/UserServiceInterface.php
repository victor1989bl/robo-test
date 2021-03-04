<?php


namespace App\Services\Abstracts;

use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * @return Collection
     */
    public function getAllUsers();

    /**
     * @return Collection
     */
    public function getAllUsersWithInfo();
}
