<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    public function list()
    {
        $user = $this->user->all();
        return response()->json([
            'message' =>'User listed',
            'data' => $user]);
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email',
                'mobile_no' => 'required|digits:10',
                'password' => 'required|min:3|max:30',
                'cpassword' => 'required|min:3|max:30|same:password',
                'profile' => 'required|mimes:jpg,bmp,png',
            ],
            [
                'name.required' => 'Please Enter Name',
                'email.required' => 'Please Enter Email',
                'mobile_no.required' => 'Please Enter Mobile No',
                'password.required' => 'Please Enter Password',
                'cpassword.required' => 'Please Enter Confirm Password',
                'cpassword.same' => 'The Confirm password And password must match.',
                'profile.required' => 'Please Select profile',
            ]
        );
        $user = $this->user->store($request->all());
        return response()->json(['data' => $user]);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $request['id'],
                'mobile_no' => 'required|digits:10',
                'profile' => 'mimes:jpg,bmp,png',
            ],
            [
                'name.required' => 'Please Enter Name',
                'email.required' => 'Please Enter Email',
                'mobile_no.required' => 'Please Enter Mobile No',
            ]
        );
        $user = $this->user->update($request->all());
        return response()->json([
            'message' => 'User updated succesfully',
            'data' => $user,
        ]);
    }
    public function delete(Request $request)
    {
        $user = $this->user->delete($request->all());
        return response()->json([
            'message' => 'User deleted succesfully',
            'data' => $user,
        ]);
    }
}
