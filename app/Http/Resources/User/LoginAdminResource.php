<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginAdminResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nick' => $this->nick,
            'email' => $this->email,
            'active' => $this->active,
            'attemps' => $this->attemps,
            'web' => $this->web,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'admin' => new AdminResource($this->admin)
        ];
    }
}
