<?php

namespace App\Repositories;

use App\Interfaces\AdminInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminInterface
{
    public function login(array $data)
    {
        $admin = Admin::where('email', $data['email'])->first();
        if (!$admin || !Hash::check($data['password'], $admin->password)) {

            return response([
                'message' => ['These Password and Email does not match.']
            ]);
        }

        return response([
            'token' => $admin->createToken('MyApp')->accessToken,
            'admin' => $admin
        ]);
    }
}
