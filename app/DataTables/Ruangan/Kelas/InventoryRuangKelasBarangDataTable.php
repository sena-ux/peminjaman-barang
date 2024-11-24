<?php

namespace App\DataTables\Ruangan\Kelas;

use App\Models\Ruangan\Kelas\InventoryRuangKelasBarang;
use Auth;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InventoryRuangKelasBarangDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                // $editButton = '<a class="btn btn-sm btn-primary mr-2" id="' . $pengaduan->id_pengaduan . '" onclick="editSiswa(this)"><i class="fas fa-edit"></i></a>';
                // $deleteButton = '<a class="btn btn-sm btn-danger mr-2" onclick="deleteSiswa(' . $pengaduan->id_pengaduan . ')"><i class="fas fa-trash-alt"></i></a>';
                if (Auth::user()->hasRole('admin|superadmin')) {
                    $tanggapi = '<a class="btn btn-sm btn-warning mr-2 ' . ($row->status === "Selesai" || $row->status === "Error" ? "d-none" : "") . '" onclick="tanggapi(' . $row->id . ')" id="id_button_tanggapi"><i class="fas fa-tools"></i> Tanggapi</a>';
                    return $tanggapi;
                } else{
                    $show = '<a class="btn btn-sm btn-info mr-2" onclick="show(' . $row->id . ')"><i class="fas fa-eye"></i></a>';
                    return $show;
                }

                // return $editButton . ' ' . $deleteButton . ' ' . $show;
            })
            ->addColumn('nama_barang', function ($row) {
                return $row->barang->nama_barang;
            })
            ->addColumn('pelapor', function ($row) {
                return $row->user->username;
            })
            ->addColumn('status', function ($row) {
                switch ($row->status) {
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
                        return '<i class="fas fa-question-circle bg-danger rounded p-2"><span>Unknown</span></i> ';
                }
            })
            ->addColumn('dokumentasi', function ($row) {
                return '<img src="' . asset('' . $row->foto . '') . '" alt="Foto dokumentasi pelapor." width="100" height="100"></img>';
            })
            ->setRowId('id')
            ->rawColumns(['checkbox', 'action', 'status', 'dokumentasi']);;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InventoryRuangKelasBarang $model): QueryBuilder
    {
        if (Auth::user()->hasRole('admin|superadmin')) {
            return $model->newQuery()->with(['kelas', 'tanggapan', 'barang']);
        } else {
            $kelasId = auth()->user()->siswa->kelas->id;
            return $model->newQuery()->with(['kelas', 'tanggapan', 'barang'])->where('id_kelas', $kelasId);
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
                'className' => 'btn btn-warning text-light m-2 rounded',
                'attr' => ['id' => 'btn-reset'],
                'action' => 'function (e, dt, node, config) {
                                resetTable();
                            }'
            ],
            [
                'text' => '<i class="fas fa-sync p-1"></i> Reload',
                'className' => 'btn btn-danger m-2 rounded',
                'attr' => ['id' => 'btn-reload'],
                'action' => 'function (e, dt, node, config) {
                                reloadTable();
                            }'
            ],
        ];

        if (Auth::user()->hasRole('siswa')) {
            $buttons[] = [
                'text' => '<i class="fas fa-plus-octagon fa-x2"></i>',
                'className' => 'text-light rounded m-2',
                'attr' => ['id' => 'btn-new'],
                'action' => 'function (e, dt, node, config) {
                                newinventoryKelas();
                            }'
            ];
        }

        return $this->builder()
            ->setTableId('inventoryruangkelasbarang-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(true)
            ->autoFill(true)
            ->autoWidth(true)
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
            Column::make('No')->text('No'),
            Column::make('nama_barang')
                ->text('Nama Barang'),
            Column::make('kode_barang')
                ->text('Kode Barang'),
            Column::make('kondisi')
                ->text('Kondisi'),
            Column::make('amount')
                ->text('Jumlah'),
            Column::make('status')
                ->text('Status'),
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
        return 'InventoryRuangKelasBarang_' . date('YmdHis');
    }
}
