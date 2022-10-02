<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function findById($id)
    {
        return User::whereId($id)->first();
    }

    public function findByEmail($email)
    {
        return User::whereEmail($email)->first();
    }

    public function isActive($user)
    {
        return $user->status;
    }

    public function equalsPassword($user, $password)
    {
        return Hash::check($password, $user->password);
    }

    public function generateLoginToken($user)
    {
        $token = $user->createToken('TokenGenerateBackOffice');
        $user->update([
            'last_login' => Carbon::now(),
            'attemps' => 0
        ]);

        return $token->plainTextToken;
    }
}
