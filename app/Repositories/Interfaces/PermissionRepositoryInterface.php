<?php

namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function all();
    public function findOne($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function assignPermissionToUser(array $data);
    public function assignPermissionToRole(array $data);
}
