<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    public function index(UserDataTable $dataTable)
    {
        $user = $this->user->all();
        return $dataTable->render('admin.user.index');
    }

    public function create()
    {
        $user = User::get();
        return view('admin.user.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'mobile_no' => 'required|digits:10',
                'password' => 'required|min:3|max:30',
                'cpassword' => 'required|min:3|max:30|same:password',
                'profile' => 'required|mimes:jpg,bmp,png',
            ],
            [
                'name.required' => 'Please Enter Name',
                'email.required' => 'Please Enter Email',
                'email.unique' => 'email already exists',
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

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
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
        return response()->json(['data' => $user]);
    }

    public function destroy(Request $request)
    {
        $user = $this->user->delete($request->all());
        return response()->json(['data' => $user]);
    }

    //chnage status
    public function statusChange(Request $request)
    {
        $id = $request['id'];
        // dd($id);
        $category = User::find($id);
        if ($category->status == "1") {
            $category->status = "0";
        } else {
            $category->status = "1";
        }
        $category->save();
        return response()->json(['data' => $category]);
    }
}
