<?php

namespace App\Repositories\Abstracts;

interface BaseRepositoryInterface
{
    public function all();
    public function getById($id);
    public function updateById($id, $data);
    public function create($data);
}
