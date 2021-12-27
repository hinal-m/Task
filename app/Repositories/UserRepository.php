<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Admin;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function all()
    {
        $user = User::get();
        return $user;
    }
    public function store(array $request)
    {

        $user = new User();
        $profile = uploadFile($request['profile'], 'profile');
        // dd($profile);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->mobile = $request['mobile_no'];
        $user->password = Hash::make($request['password']);
        $user->profile = $profile;
        $user->save();
        return $user;
    }

    public function update(array $request)
    {
        $user = User::find($request['id']);
        if (isset($request['profile'])) {
            $profile = $user->getRawOriginal('profile');
            if (file_exists(public_path('storage/profile/' . $profile))) {
                @unlink(public_path('storage/profile/' . $profile));
            }
            $images = uploadFile($request['profile'], 'profile');
            $user->profile = $images;
        } else {
            $images = $user->getRawOriginal('profile');
        }


        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->mobile = $request['mobile_no'];
        $user->save();
        return $user;
    }

    public function delete(array $request)
    {
        $user = User::find($request['id']);
        $user->delete();
        return $user;
    }
}
