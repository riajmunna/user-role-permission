<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
class AuthenticationController extends Controller
{
    private $authRepository;

    // Inject authentication repository dependency
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    // user login with credential validation
    public function userLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check login credentials
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json($this->authRepository->login($data), 200);
    }

    // user registration with validation
    public function userRegistration(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|min:8',
        ]);

        // check password confirmation
        if($data['password'] != $data['confirmPassword']){
            return response()->json(['message' => 'Password & confirm password mismatched'], 401);
        }

        return response()->json($this->authRepository->register($data), 201);
    }
}
