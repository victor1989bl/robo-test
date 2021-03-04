<?php

namespace App\Repositories\Abstracts;

use App\Models\User;

interface  UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Изменяем баланс пользователя
     *
     * @param User $user
     * @param $balance
     * @param bool $increment true - прибавляем, false - отнимаем
     * @return mixed
     */
    public function updateBalance(User $user, $balance, $increment);
}
