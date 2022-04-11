<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "document_type" => $this->document_type,
            "document_number" => $this->document_number,
            "name" => $this->name,
            "lastname" => $this->lastname,
            "birthday" => $this->birthday,
            "gender" => $this->gender,
            "country_id" => $this->country_id,
            "state_id" => $this->state_id,
            "city_id" => $this->city_id,
            "parish_id" => $this->parish_id,
            "address" => $this->address,
            "phone" => $this->phone,
            "photo" => $this->photo,
            "photo_url" => $this->photo_url,
            "language" => $this->language,
            "timezone" => $this->timezone
        ];
    }
}
