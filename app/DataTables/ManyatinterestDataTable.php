<?php

namespace App\DataTables;

use App\Models\Manyatinterest;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ManyatinterestDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->editColumn('deposite',function($data){
            return  '<a data-id="'.$data->id.'" id="status" style="color:white" class="btn-sm btn-success">Deposite</a>';
        })
        ->editColumn('status', function($data){
            if($data->status == '1'){
               return  '<a data-id="'.$data->id.'" id="status" style="color:white" class="btn-sm btn-success">Active</a>';
            }else{
               return '<a data-id="'.$data->id.'" id="status" style="color:white" class="btn-sm btn-danger">Unpaid</a>';
            }
        })
        ->rawColumns(['status'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Moneyinterest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Manyatinterest $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
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

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('amount'),
            Column::make('interest_rate'),
            Column::make('payment_pariod_start'),
            Column::make('total_amount'),
            Column::make('status'),
            Column::make('action'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Moneyinterest_' . date('YmdHis');
    }
}
