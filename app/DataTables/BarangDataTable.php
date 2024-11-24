<?php

namespace App\DataTables;

use App\Models\Barang;
use App\Models\InventoryBarang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BarangDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                $show = '<a class="btn btn-sm btn-info mr-2" onclick="showInventoryBarang(' . $row->id . ')"><i class="fas fa-eye  "></i></a>';
                $editButton = '<a class="btn btn-sm btn-primary mr-2" ><i class="fas fa-edit"></i></a>';
                $deleteButton = '<a class="btn btn-sm btn-danger mr-2"><i class="fas fa-trash-alt"></i></a>';

                // return $editButton . ' ' . $deleteButton . ' ' . $show;
                return $deleteButton;
            })
            ->addColumn('No', function ($row) use (&$no) {
                return $no++;
            })
            ->addColumn('kode_barang', function ($row) {
                return $row->category->name;
            })
            ->addColumn('fotoBarang', function ($row) {
                $url = asset($row->foto_barang);
                return '<img src="'.$url.'" alt="image barang" class="img-thumbnail" width="100" height="100">';
            })
            ->addColumn('jenis', function ($row) {
                return $row->category->name;
            })
            ->addColumn('created', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->addColumn('updated', function ($row) {
                return $row->updated_at->diffForHumans();
            })
            ->addColumn('deskripsiUpdate', function ($row) {
                return $row->deskripsi;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'created', 'updated', 'jenis', 'deskripsiUpdate', 'fotoBarang']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Barang $model): QueryBuilder
    {
        return $model->newQuery()->with(['category']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('barang-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->responsive(true)
            ->autoFill(true)
            ->autoWidth(true)
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
                        'text' => '<i class="fas fa-download p-1"></i> Import',
                        'className' => 'btn btn-success',
                        'attr' => ['id' => 'btn-import'],
                        'action' => 'function (e, dt, node, config) {
                                        importDataBarang()
                                    }'
                    ],
                    [
                        'text' => '<i class="fa-solid fa-plus p-1"></i>',
                        'className' => 'btn btn-primary',
                        'attr' => ['id' => 'btn-new'],
                        'action' => 'function (e, dt, node, config) {
                                        window.location.href = "' . route('barang.create') . '";
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
            Column::make('No')
                ->width(60)
                ->className('align-middle'),
            Column::make('fotoBarang')
                ->className('align-middle'),
            Column::make('nama_barang')
                ->className('align-middle'),
            Column::make('deskripsiUpdate')
                ->text('Deskripsi')
                ->className('text-start align-middle'),
            Column::make('tahun_pengadaan')
                ->text('Tahun Pengadaan')
                ->className('text-start align-middle'),
            Column::make('harga')
                ->text('Harga Barang')
                ->className('text-start align-middle'),
            Column::make('sumber_dana')
                ->text('Sumber Dana')
                ->className('text-start align-middle'),
            Column::make('jenis')
                ->text('Jenis barang')
                ->className('align-middle'),
            Column::make('total_barang')
                ->text('Total Barang')
                ->className('align-middle'),
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Barang_' . date('YmdHis');
    }
}
