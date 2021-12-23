<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ManyatinterestDataTable;
use App\Http\Controllers\Controller;
use App\Models\Interest;
use App\Models\Manyatinterest;
use Illuminate\Http\Request;

class ManyatinterestController extends Controller
{
    public function index(ManyatinterestDataTable $dataTable)
    {
        $many = Manyatinterest::all();
        return $dataTable->render('admin.maneyinterest.index');
    }

    public function create()
    {
        return view('admin.maneyinterest.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|exists:users,name',
                'amount' => 'required',
            ],
            [
                'name.exists' => 'This name is not exists on users table',
            ]
        );

        if ($request['amount'] <= 500) {

            $amount = $request['amount'] * 5 / 100;
        } elseif ($request['amount'] > 500 && $request['amount'] <= 1000) {


            $amount = $request['amount'] * 10 / 100;
        } elseif ($request['amount'] > 1001) {

            $amount = $request['amount'] * 15 / 100;
        }
        $user = new Manyatinterest();
        $user->name = $request->name;
        $user->amount = $request['amount'];
        $user->interest_rate = $amount;
        $user->	payment_pariod_start = $request->start_date;
        $user->	payment_pariod_end = $request->end_date;
        $user->save();
        return response()->json(['data' => $user]);

    }

    public function deposite(Request $request)
    {
        $money = Manyatinterest::find($request['id']);
        $total = $money->amount + $money->interest_rate;
        $money->status = '1';
        $money->total_amount = $total;
        $money->save();
        return response()->json(['data' => $money]);
    }
}
