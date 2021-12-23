<?php

namespace App\DataTables;

use App\Models\Manyatinterest;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Http\Request;

use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ManyatinterestDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->addColumn('deposite',function($data){
            return  '<a data-id="'.$data->id.'" id="deposite" style="color:white" class="btn-sm btn-warning">Deposite</a>';
        })
        ->editColumn('status', function($data){
            if($data->status == '1'){
               return  '<a data-id="'.$data->id.'" id="status" style="color:white" class="btn-sm btn-success">Paid</a>';
            }else{
               return '<a data-id="'.$data->id.'" id="status" style="color:white" class="btn-sm btn-danger">Unpaid</a>';
            }
        })

        ->rawColumns(['status','deposite'])
        ->addIndexColumn();
    }
    public function query(Manyatinterest $model,Request $request)
    {
        if($request->type)
        {
            $model = $model->where('status',$request->type);
        }
        return $model->newQuery();

    }
    public function html()
    {
        return $this->builder()
                    ->setTableId('moneyinterest-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('amount'),
            Column::make('interest_rate'),
            Column::make('payment_pariod_start'),
            Column::make('payment_pariod_end'),
            Column::make('total_amount'),
            Column::make('status'),
            Column::make('deposite'),
        ];
    }
    protected function filename()
    {
        return 'Moneyinterest_' . date('YmdHis');
    }
}
