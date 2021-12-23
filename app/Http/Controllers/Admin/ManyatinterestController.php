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
        $interest = Interest::get();
        foreach ($interest as $interest) {

            if ($request['amount'] <= 500) {

                $amount = $request['amount'] * $interest['interest_rate'] / 100;

            } elseif ($request['amount'] > 500 && $request['amount'] <= 1000) {
                dd($interest['interest_rate']);
                $amount = $request['amount'] * 10 / 100;
                dd($amount);
            } elseif ($request['amount'] > 1001) {
                $amount = $request['amount'] * 15 / 100;
                dd($amount);
            }
        }
        $user = new Manyatinterest();
        $user->name = $request->name;
        $user->amount = $request->$amount;
        $user->save();
        dd($user);
    }
}
