<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;

    // Inject user repository dependency
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return response()->json($this->userRepository->all(), 200);
    }

    public function show($id)
    {
        return response()->json($this->userRepository->find($id), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Custom validation to check email duplicacy
        if (User::where('email', $data['email'])->first()) {
            return response()->json([
                'errorMessage' => "Already has an user with email: " . $data['email']
            ], 400);
        }

        $data['password'] = bcrypt($data['password']);
        return response()->json($this->userRepository->create($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
        ]);

        // Custom validation to check email duplicacy
        if (User::where('email', $data['email'])->first()) {
            return response()->json([
                'errorMessage' => "Already has an user with email: " . $data['email']
            ], 400);
        }

        // Encrypt the password
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return response()->json($this->userRepository->update($id, $data), 200);
    }

    public function destroy($id)
    {
        return response()->json($this->userRepository->delete($id), 200);
    }
}
