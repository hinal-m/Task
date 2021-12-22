<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->addColumn('action', function ($data) {
                return '<a href="' . url('admin/edit/'. $data->id) .
                '" class="btn btn-dark btn-icon-text"> Edit </a>&nbsp;<a id="delete" data-id="'.$data->id.'" style="color:white" class="btn-sm btn-danger">Delete</a>';
            })
            ->editColumn('profile', function ($data) {
                return '<img src="'.$data->profile.'" style="color:white" class="img-thumbnail"  width="100px" height="100px">';
            })
            ->editColumn('status', function($data){
                if($data->status == '1'){
                   return  '<a data-id="'.$data->id.'" id="status" style="color:white" class="btn-sm btn-success">Active</a>';
                }else{
                   return '<a data-id="'.$data->id.'" id="status" style="color:white" class="btn-sm btn-danger">Inactive</a>';
                }
            })
             ->rawColumns(['profile','action','status'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('user-table')
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
            Column::make('email'),
            Column::make('mobile'),
            Column::make('profile'),
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
        return 'User_' . date('YmdHis');
    }
}
