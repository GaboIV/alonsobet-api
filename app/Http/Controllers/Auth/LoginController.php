<?php

namespace App\Http\Controllers\Auth;


use App\Constants\Messages;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use App\Http\Resources\User\LoginAdminResource;

class LoginController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function loginAdmin(LoginAdminRequest $request)
    {
        $credentials = $request->validated();

        $user = $this->service->findByEmail($credentials['email']);

        if (!$user || !$user->admin) {
            return $this->errorResponse(Messages::USER_NOT_FOUND, 403);
        }

        if (!$this->service->isActive($user)) {
            return $this->errorResponse(Messages::USER_NOT_ACTIVATED, 403);
        }

        if (!$this->service->equalsPassword($user, $credentials["password"])) {
            return $this->errorResponse(Messages::BAD_CREDENTIALS, 403);
        }

        $token = $this->service->generateLoginToken($user);

        return $this->successResponse([
            'access_token' => $token,
            'user' => new LoginAdminResource($user)
        ], 200);
    }
}
