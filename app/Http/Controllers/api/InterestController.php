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
        return response()->json([
            'message' =>'Interest listed',
            'data' => $interest]);
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
        return response()->json(['data' => $interest]);
    }

    public function deposite(Request $request)
    {
        $money = $this->interest->deposite($request->all());
        return response()->json([
            'message' =>'Amount deposite succesfully',
            'data' => $money]);
    }

    public function getUnpaid(Request $request)
    {
        $status = $this->interest->getUnpaid($request->all());
        return response()->json([
            'message' =>'Unpaid status list',
            'data' => $status]);
    }

    public function getPaid(Request $request)
    {
        $status = $this->interest->getPaid($request->all());
        return response()->json([
            'message' =>'Paid status list',
            'data' => $status]);
    }
}
