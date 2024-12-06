<?php


namespace App\Repositories;


use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;
use App\Models\UserRole;
use function Illuminate\Auth\id;
use function Illuminate\Database\Query\update;

class RoleRepository implements RoleRepositoryInterface
{

    public function all()
    {
        return Role::all();
    }

    public function findOne($id)
    {
        return Role::find($id);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update($id, array $data)
    {
        $role = Role::find($id);
        $role->update($data);
        return $role;
    }

    public function delete($id)
    {
        return Role::destroy($id);
    }

    public function assignRoleToUser(array $data)
    {
        return UserRole::create($data);
    }
}
