<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use function Illuminate\Bus\find;
use function Laravel\Pail\all;
use function Laravel\Pail\create;

class RoleController extends Controller
{
    private $roleRepository;

    // Inject role repository dependency
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        return response()->json($this->roleRepository->all(), 200);
    }

    public function show($id)
    {
        return response()->json($this->roleRepository->findOne($id), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        // Check for existing role name duplicacy
        if (Role::where('name', $data['name'])->first()) {
            return response()->json([
                'errorMessage' => "Already has a role named: " . $data['name']
            ], 400);
        }

        return response()->json($this->roleRepository->create($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        // Check for existing role name duplicacy
        if (Role::where('name', $data['name'])->first()) {
            return response()->json([
                'errorMessage' => "Already has a role named: " . $data['name']
            ], 400);
        }

        return response()->json($this->roleRepository->update($id, $data), 200);
    }

    public function destroy($id)
    {
        return response()->json($this->roleRepository->delete($id), 200);
    }

    // Assign role to user
    public function assignRoleToUser(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'role_id' => 'required|integer',
        ]);

        // Validate user existence
        if (!User::find($data['user_id'])) {
            return response()->json([
                'errorMessage' => "User with ID " . $data['user_id'] . " is not found! please try again."
            ], 400);
        }

        // Validate role existence
        if (!Role::find($data['role_id'])) {
            return response()->json([
                'errorMessage' => "Role with ID " . $data['role_id'] . " is not found! please try again."
            ], 400);
        }

        // Check if role is already assigned to user
        $isExist = UserRole::where('user_id', $data['user_id'])
            ->where('role_id', $data['role_id'])
            ->exists();

        if ($isExist) {
            return response()->json([
                'errorMessage' => "Role with ID " . $data['role_id'] . " is already assigned to User with ID " . $data['user_id']
            ], 400);
        }

        return response()->json($this->roleRepository->assignRoleToUser($data));
    }
}
