<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserPermission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permissionRepository;

    // Inject permission repository dependency
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        return response()->json($this->permissionRepository->all(), 200);
    }

    public function show($id)
    {
        return response()->json($this->permissionRepository->findOne($id), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string"
        ]);

        // Check for existing permission name
        if (Permission::where('name', $data['name'])->first()) {
            return response()->json([
                'errorMessage' => "Already has a permission named: " . $data['name']
            ], 400);
        }

        return response()->json($this->permissionRepository->create($data), 201);
    }

    public function destroy($id)
    {
        return response()->json($this->permissionRepository->delete($id), 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string"
        ]);

        // Check for existing permission name
        if (Permission::where('name', $data['name'])->first()) {
            return response()->json([
                'errorMessage' => "Already has a permission named: " . $data['name']
            ], 400);
        }

        return response()->json($this->permissionRepository->update($id, $data), 200);
    }

    // Assign permission to user
    public function assignPermissionToUser(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'permission_id' => 'required|integer',
        ]);

        // Validate user existence
        if (!User::find($data['user_id'])) {
            return response()->json([
                'errorMessage' => "User with ID " . $data['user_id'] . " is not found! please try again."
            ], 400);
        }

        // Validate permission existence
        if (!Permission::find($data['permission_id'])) {
            return response()->json([
                'errorMessage' => "Permission with ID " . $data['permission_id'] . " is not found! please try again."
            ], 400);
        }

        // Check if permission is already assigned to user
        $isExist = UserPermission::where('user_id', $data['user_id'])
            ->where('permission_id', $data['permission_id'])
            ->exists();

        if ($isExist) {
            return response()->json([
                'errorMessage' => "Permission with ID " . $data['permission_id'] . " is already assigned to User with ID " . $data['user_id']
            ], 400);
        }

        return response()->json($this->permissionRepository->assignPermissionToUser($data), 200);
    }

    // Assign permission to role
    public function assignPermissionToRole(Request $request)
    {
        $data = $request->validate([
            'role_id' => 'required|integer',
            'permission_id' => 'required|integer',
        ]);

        // Validate role existence
        if (!Role::find($data['role_id'])) {
            return response()->json([
                'errorMessage' => "Role with ID " . $data['role_id'] . " is not found! please try again."
            ], 400);
        }

        // Validate permission existence
        if (!Permission::find($data['permission_id'])) {
            return response()->json([
                'errorMessage' => "Permission with ID " . $data['permission_id'] . " is not found! please try again."
            ], 400);
        }

        // Check if permission is already assigned to role
        $isExist = RolePermission::where('role_id', $data['role_id'])
            ->where('permission_id', $data['permission_id'])
            ->exists();

        if ($isExist) {
            return response()->json([
                'errorMessage' => "Permission with ID " . $data['permission_id'] . " is already assigned to Role with ID " . $data['role_id']
            ], 400);
        }

        return response()->json($this->permissionRepository->assignPermissionToRole($data), 200);
    }
}
