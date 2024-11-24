<?php

namespace App\DataTables;

use App\Models\Barang;
use App\Models\Pengaduan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KerusakanUmumDataTable extends DataTable
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
                return '<input type="checkbox" name="checkbox[]" value="' . $row->id_pengaduan . '" class="siswa-checkbox" onclick="updateSelectAll()">';
            })
            ->addColumn('No', function ($row) use (&$no) {
                return $no++;
            })
            ->addColumn('action', function (Pengaduan $pengaduan) {
                $show = '<a class="btn btn-sm btn-info mr-2" onclick="show(' . $pengaduan->id_pengaduan . ')"><i class="fas fa-eye  "></i></a>';
                $editButton = '<a class="btn btn-sm btn-primary mr-2" id="' . $pengaduan->id_pengaduan . '" onclick="editSiswa(this)"><i class="fas fa-edit"></i></a>';
                $deleteButton = '<a class="btn btn-sm btn-danger mr-2" onclick="deleteSiswa(' . $pengaduan->id_pengaduan . ')"><i class="fas fa-trash-alt"></i></a>';
                $tanggapi = '<a class="btn btn-sm btn-warning mr-2 '. ($pengaduan->status_pengaduan === "Selesai" || $pengaduan->status_pengaduan === "Error" ? "d-none" : "") .'" onclick="tanggapi(' . $pengaduan->id_pengaduan . ')" id="id_button_tanggapi"><i class="fas fa-tools"></i> Tanggapi</a>';

                // return $editButton . ' ' . $deleteButton . ' ' . $show;
                return $tanggapi;
            })
            ->addColumn('nama_barang', function (Pengaduan $pengaduan) {
                return $pengaduan->nama_barang;
            })
            ->addColumn('pelapor', function (Pengaduan $pengaduan) {
                return $pengaduan->pelapor->user->username;
            })
            ->addColumn('status_pengaduan', function ($row) {
                switch ($row->status_pengaduan) {
                    case 'Pending':
                        return '<span class="bg-warning rounded p-2"><i class="fas fa-sync fa-spin p-2"></i>Pending </span> ';
                    case 'Error':
                        return '<i class="fas fa-exclamation-triangle bg-danger rounded m-2 p-2">Error</i> ';
                    case 'Validasi':
                        return '<i class="fas fa-check-circle bg-success rounded p-2">Validasi</i> ';
                    case 'Dalam Pengerjaan':
                        return '<i class="fas fa-cogs bg-info rounded p-2">Dalam Pengerjaan</i> ';
                    case 'Sedang Diproses':
                        return '<i class="fas fas fa-sync-alt fa-spin bg-warning rounded p-2">Sedang Diproses</i> ';
                    case 'Selesai':
                        return '<i class="fas fa-check-circle bg-success rounded p-2">Selesai</i> ';
                    default:
                        return '<i class="fas fa-question-circle bg-danger rounded p-2">Unknown</i> ';
                }
            })
            ->addColumn('images', function ($row) {
                return '<img src="' . asset('uploads/' . $row->foto_kerusakan . '') . '" alt="' . $row->foto_kerusakan . '" width="100" height="100"></img>';
            })
            ->setRowId(function ($pengaduan) {
                return $pengaduan->id_pengaduan;
            })
            ->setRowId('id')
            ->rawColumns(['checkbox', 'action', 'status_pengaduan', 'images']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Pengaduan $model): QueryBuilder
    {
        $userId = auth()->user()->id;
        if(Auth::user()->hasRole('admin|superadmin')) {
            return $model->newQuery()->where('status_pengaduan' , '!=', 'Selesai');
        } else{
            return $model->newQuery()->where('status_pengaduan' , '!=', 'Selesai')->whereHas('pelapor', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $buttons = [
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
                'attr' => ['id' => 'btn-add'],
                'action' => 'function (e, dt, node, config) {
                                addPengaduan();
                            }'
            ],
        ];

        // Menambahkan tombol Add dan Remove Selected hanya untuk admin
        if (Auth::user()->hasRole('admin|superadmin|staf')) {
            $buttons[] = [
                'extend' => 'print',
                'className' => 'btn btn-info p-2',
                'text' => '<i class="fas fa-print p-1"></i> Print',
                'attr' => ['id' => 'btn-print']
            ];
            $buttons[] = [
                'extend' => 'excel',
                'className' => 'btn btn-danger',
                'text' => '<i class="fas fa-file-excel p-1"></i> Excel',
                'attr' => ['id' => 'btn-excel']
            ];
            $buttons[] = [
                'extend' => 'csv',
                'className' => 'btn btn-secondary',
                'text' => '<i class="fas fa-file-csv p-1"></i> CSV',
                'attr' => ['id' => 'btn-csv']
            ];
            $buttons[] = [
                'extend' => 'pdf',
                'className' => 'btn btn-success',
                'text' => '<i class="fas fa-file-pdf p-1"></i> PDF',
                'attr' => ['id' => 'btn-pdf']
            ];
        }

        // if (Auth::user()->hasRole('admin|superadmin')) {
        //     $buttons[] = [
        //         'text' => '<i class="fas fa-trash-alt p-1"></i> Remove Selected',
        //         'className' => 'btn btn-danger',
        //         'attr' => ['id' => 'btn-remove'],
        //         'action' => 'function (e, dt, node, config) {
        //                         removeSelected();
        //                     }'
        //     ];
        //     $buttons[] = [
        //         'text' => '<i class="fas fa-download p-1"></i> Import',
        //         'className' => 'btn btn-success',
        //         'attr' => ['id' => 'btn-import'],
        //         'action' => 'function (e, dt, node, config) {
        //                         importDataSiswa()
        //                     }'
        //     ];
        // }


        return $this->builder()
            ->setTableId('kerusakanumum-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            // ->addAction(['width' => '80px'])
            ->responsive(true)
            ->autoWidth(true)
            ->autoFillColumns(true)
            ->responsiveDetails(true)
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'buttons' => $buttons
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
                ->orderable(false)
                ->searchable(false)
                ->width('60')
                ->addClass('text-center align-middle'),
            Column::computed('No')
                ->title('No')->width('60')
                ->addClass('text-center align-middle'),
            Column::make('images')
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-center align-middle'),
            Column::make('nama_barang')
                ->text('Nama Barang')
                ->addClass('align-middle'),
            Column::make('title')
                ->text('Judul')
                ->addClass('align-middle'),
            Column::make('message')
                ->text('Isi Pesan')
                ->addClass('align-middle'),
            Column::make('tanggal_pengaduan')
                ->addClass('text-start align-middle'),
            Column::make('status_pengaduan')
                ->addClass('text-center align-middle'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center align-middle')
                ->visible(auth()->user()->hasRole('superadmin|admin')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'KerusakanUmum_' . date('YmdHis');
    }
}
