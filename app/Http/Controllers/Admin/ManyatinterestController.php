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
        foreach($interest as $interest)
        {
            if($request['amount'] <= $interest['amount'])
            {

                // dd($interest['interest_rate']);
                // $aa = $request['amount']*$interest['interest_rate']/100;
                // dd($aa);
            }
            if(($request['amount'] > $interest['amount']) && ($request['amount'] <= $interest['amount']))
            {
                // dd($interest['interest_rate']);
                $aa = ($request['amount']*$interest['interest_rate'])/100;
                dd($aa);
            }
            elseif($request['amount'] < $interest['amount'])
            {

            }

        }
        $user = new Manyatinterest();
        $user->name = $request->name;



    }
}
