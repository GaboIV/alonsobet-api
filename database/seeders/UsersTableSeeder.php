<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'nick' => 'admin',
            'email' => 'admin@alonsobet.xyz',
            'status' => 1,
            'attemps' => 5,
            'web' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => '222222',
            'code_security' => '2222',
            'remember_token' => NULL,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Admin::create([
            "user_id" => $user->id,
            "document_type" => "V",
            "document_number" => "00000001",
            "name" => "Administrador",
            "lastname" => "AlonsoBet",
            "birthday" => "2021-04-08",
            "gender" => "M",
            "country_id" => "231",
            "state_id" => "2",
            "city_id" => "8",
            "parish_id" => "26",
            "address" => "Ubr. Mene Grande, Cada D-12",
            "phone" => "0426-2858771",
        ]);
    }
}
