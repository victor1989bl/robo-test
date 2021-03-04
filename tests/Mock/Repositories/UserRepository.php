<?php


namespace Tests\Mock\Repositories;


use App\Models\User;
use App\Repositories\Abstracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function updateById($id, $data)
    {
        // TODO: Implement updateById() method.
    }

    public function create($data)
    {
        // TODO: Implement create() method.
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

        return $user;
    }
}
