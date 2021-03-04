<?php

namespace App\Repositories;

class BaseRepository
{
    protected $model;

    public function all()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function updateById($id, $data)
    {
         $this->model
            ->find($id)
            ->update($data);

         return $this->model->fresh();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
