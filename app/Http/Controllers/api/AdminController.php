<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $admin;
    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }
    public function login(Request $request)
    {
        return $this->admin->login($request->all());
    }
    public function logout(Request $request)
    {
        $user = request()->user();
        if ($user) {
            $token = request()->user()->token();
            $token->revoke();
            $user->save();
            return response()->json([
                'message' => 'admin logout Succesfully'
            ]);
        } else {
            return response()->json([
                'message' => 'dsfdsf',
            ]);
        }
    }
}
