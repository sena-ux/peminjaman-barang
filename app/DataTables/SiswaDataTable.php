<?php

namespace App\DataTables;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $no = 1;
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn("checkbox", function ($row) {
                return '<input type="checkbox" name="checkbox[]" value="' . $row->user->id . '" class="siswa-checkbox" onclick="updateSelectAll()">';
            })
            ->addColumn('No', function ($row)  use (&$no) {
                return $no++;
            })
            ->addColumn('action', function (Siswa $siswa) {
                $show = '<a class="btn btn-sm btn-info mr-2" onclick="show(' . $siswa->user->id . ')"><i class="fas fa-eye  "></i></a>';
                $editButton = '<a class="btn btn-sm btn-primary mr-2" id="' . $siswa->user->id . '" onclick="editSiswa(this)"><i class="fas fa-edit"></i></a>';
                $deleteButton = '<a class="btn btn-sm btn-danger mr-2" onclick="deleteSiswa(' . $siswa->user->id . ')"><i class="fas fa-trash-alt"></i></a>';

                return $editButton . ' ' . $deleteButton . ' ' . $show;
            })
            ->addColumn('username', function (Siswa $siswa) {
                return $siswa->user->username;
            })
            ->addColumn('email', function (Siswa $siswa) {
                return $siswa->user->email;
            })
            ->addColumn('kelas', function (Siswa $siswa) {
                return $siswa->kelas->name;
            })
            ->setRowId('id')
            ->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Siswa $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('siswa-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(true)
            ->autoWidth(true)
            ->autoFillColumns(true)
            // ->buttons([
            //     Button::make('excel'),
            //     Button::make('csv'),
            //     Button::make('pdf'),
            //     Button::make('print'),
            //     // Button::make('Reset')->action('resetTable()'),
            //     // Button::make('customReload')->text('reload')->action('reloadTable()'),
            // ]);
            ->parameters([
                'buttons' => [
                    [
                        'extend' => 'print',
                        'className' => 'btn btn-info p-2',
                        'text' => '<i class="fas fa-print p-1"></i> Print',
                        'attr' => ['id' => 'btn-print']
                    ],
                    [
                        'extend' => 'excel',
                        'className' => 'btn btn-danger',
                        'text' => '<i class="fas fa-file-excel p-1"></i> Excel',
                        'attr' => ['id' => 'btn-excel']
                    ],
                    [
                        'extend' => 'csv',
                        'className' => 'btn btn-secondary',
                        'text' => '<i class="fas fa-file-csv p-1"></i> CSV',
                        'attr' => ['id' => 'btn-csv']
                    ],
                    [
                        'extend' => 'pdf',
                        'className' => 'btn btn-success',
                        'text' => '<i class="fas fa-file-pdf p-1"></i> PDF',
                        'attr' => ['id' => 'btn-pdf']
                    ],
                    [
                        'text' => '<i class="fas fa-undo p-1"></i> Reset',
                        'className' => 'btn btn-warning text-light',
                        'attr' => ['id' => 'btn-reset'],
                        'action' => 'function (e, dt, node, config) {
                                        resetTable();
                                    }'
                    ],
                    [
                        'text' => '<i class="fas fa-sync p-1"></i> Reload',
                        'className' => 'btn btn-danger',
                        'attr' => ['id' => 'btn-reload'],
                        'action' => 'function (e, dt, node, config) {
                                        reloadTable();
                                    }'
                    ],
                    [
                        'text' => '<i class="fas fa-plus-circle p-1"></i> Add',
                        'className' => 'btn btn-info',
                        'attr' => ['id' => 'btn-reload'],
                        'action' => 'function (e, dt, node, config) {
                                        addSiswa();
                                    }'
                    ],
                    [
                        'text' => '<i class="fas fa-trash-restore p-1"></i> Reset Password All',
                        'className' => 'btn btn-danger',
                        'attr' => ['id' => 'btn-reload',],
                        'action' => 'function (e, dt, node, config) {
                                        resetPasswordAll();
                                    }'
                    ],
                    [
                        'text' => '<i class="fas fa-trash-alt p-1"></i> Remove Selected',
                        'className' => 'btn btn-danger',
                        'attr' => ['id' => 'btn-reload',],
                        'action' => 'function (e, dt, node, config) {
                                        removeSelected();
                                    }'
                    ],
                    [
                        'text' => '<i class="fas fa-download p-1"></i> Import',
                        'className' => 'btn btn-success',
                        'attr' => ['id' => 'btn-import'],
                        'action' => 'function (e, dt, node, config) {
                                        importDataSiswa()
                                    }'
                    ],
                ]
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('checkbox')
                ->title('<input type="checkbox" id="select-all-checkbox" onclick= checkAll(this)>')
                ->text('checkbox')
                ->orderable(false)
                ->searchable(false),
            Column::computed('No')
                ->title('No')->width('60')->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
            Column::make('nisn')->addClass('text-left showTable'),
            Column::make('name'),
            Column::make('kelas'),
            Column::make('email'),
            Column::make('username'),
            Column::make('no_hp')->addClass('text-left showTable'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Siswa_' . date('YmdHis');
    }
}
