<?php


namespace App\Repositories;

use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserPermission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use function Illuminate\Auth\id;

class PermissionRepository implements PermissionRepositoryInterface
{

    public function all()
    {
        return Permission::all();
    }

    public function findOne($id)
    {
        return Permission::find($id);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function update($id, array $data)
    {
        $permission = Permission::find($id);
        $permission->update($data);
        return $permission;
    }

    public function delete($id)
    {
        return Permission::destroy($id);
    }

    public function assignPermissionToUser(array $data)
    {
        return UserPermission::create($data);
    }

    public function assignPermissionToRole(array $data)
    {
        return RolePermission::create($data);
    }
}
