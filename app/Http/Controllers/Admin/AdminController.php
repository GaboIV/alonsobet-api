<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function me()
    {
        $auth_user = Auth::user();

        $user = User::where('id', $auth_user->id)
            ->with('admin')
            ->first();

        return $this->successResponse($user, 200);
    }
}
