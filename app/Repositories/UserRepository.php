<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Abstracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Изменяем баланс пользователя
     *
     * @param User $user
     * @param $balance
     * @param bool $increment true - прибавляем, false - отнимаем
     * @return mixed
     */
    public function updateBalance(User $user, $balance, $increment)
    {
        if($increment){
            $user->metadata->increment('balance', $balance);
        } else {
            $user->metadata->decrement('balance', $balance);
        }

        return $this->model->fresh();
    }
}
