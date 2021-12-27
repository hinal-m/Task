<?php

namespace App\Repositories;

use App\Interfaces\InterestInterface;
use App\Models\Manyatinterest;

;

class InterestRepository implements InterestInterface
{
    public function list()
    {
        $interest = Manyatinterest::get();
        return $interest;
    }
    public function store(array $request)
    {
        if ($request['amount'] <= 500) {

            $amount = $request['amount'] * 5 / 100;
        } elseif ($request['amount'] > 500 && $request['amount'] <= 1000) {


            $amount = $request['amount'] * 10 / 100;
        } elseif ($request['amount'] > 1001) {

            $amount = $request['amount'] * 15 / 100;
        }
        $interest = new Manyatinterest();
        $interest->name = $request['name'];
        $interest->amount = $request['amount'];
        $interest->interest_rate = $amount;
        $interest->	payment_pariod_start = $request['start_date'];
        $interest->	payment_pariod_end = $request['end_date'];
        $interest->save();
        return $interest;
    }

    public function deposite(array $request)
    {
        $money = Manyatinterest::find($request['id']);
        $total = $money->amount + $money->interest_rate;
        $money->status = '1';
        $money->total_amount = $total;
        $money->save();
        return $money;
    }

    public function getUnpaid()
    {
        $interest = Manyatinterest::where('status','0')->get();
        return $interest;
    }

    public function getPaid()
    {
        $interest = Manyatinterest::where('status','1')->get();
        return $interest;
    }
}
