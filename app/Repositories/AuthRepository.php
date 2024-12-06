<?php


namespace App\Repositories;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    // Generate authentication token
    public function login(array $data)
    {
        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    // Create a new user account
    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return $user;
    }
}
