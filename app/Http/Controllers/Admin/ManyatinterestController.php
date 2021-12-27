<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ManyatinterestDataTable;
use App\Http\Controllers\Controller;
use App\Models\Interest;
use App\Models\Manyatinterest;
use App\Repositories\InterestRepository;
use Illuminate\Http\Request;

class ManyatinterestController extends Controller
{
    protected $interest;
    public function __construct(InterestRepository $interest)
    {
        $this->interest = $interest;
    }
    public function index(ManyatinterestDataTable $dataTable)
    {
        $order = $this->interest->list();
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
        return response()->json(['data' => $money]);
    }
}
