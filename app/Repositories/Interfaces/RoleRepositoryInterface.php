<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{
    public function all();
    public function findOne($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function assignRoleToUser(array $data);
}
