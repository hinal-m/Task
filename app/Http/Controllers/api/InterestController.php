<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\InterestRepository;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    protected $interest;
    public function __construct(InterestRepository $interest)
    {
        $this->interest = $interest;
    }

    public function list(Request $request)
    {
        $interest = $this->interest->list($request->all());
        return $this->response($interest);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|exists:users,name|regex:/^[\pL\s\-]+$/u',
                'amount' => 'required|numeric',
            ],
            [
                'name.exists' => 'This name is not exists on users table',
            ]
        );
        $interest = $this->interest->store($request->all());
        return $this->response($interest);
    }

    public function deposite(Request $request)
    {
        $money = $this->interest->deposite($request->all());
        return $this->response($money);
    }

    public function getUnpaid(Request $request)
    {
        $status = $this->interest->getUnpaid($request->all());
        return $this->response($status);
    }

    public function getPaid(Request $request)
    {
        $status = $this->interest->getPaid($request->all());
        return $this->response($status);

    }
}
