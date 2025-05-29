<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Lansia;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class LansiaTable extends DataTableComponent
{
    protected $model = Lansia::class;

    public function builder(): Builder
    {
        return Lansia::query();
    }
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setOfflineIndicatorStatus(true);
        // $this->setLoadingPlaceholderStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            return [
                'class' => 'text-capitalize',
            ];
        });
        $this->setAdditionalSelects(['lansias.uuid as id']);
        $this->setLoadingPlaceholderBlade('layout.panel.loader');
        $this->setEmptyMessage(__('No data available in table'));
        $this->setConfigurableAreas([
            'before-toolbar' => [
                'components.table.header-tools',
                $this->import(),
            ]
        ]);
    }

    // public function topFilterIsEnabled()
    // {

    //     return [
    //         SelectFilter::make(__('roles'), 'roles')
    //             ->options([
    //                 '' => 'Semua',
    //                 'Lansia' => 'Lansia',
    //             ])

    //     ];
    // }

    public function import()
    {
        return [
            'title' => 'Import',
            'icon' => 'fa fa-file-import',
            'id' => 'file',
            'url' => route('lansia.import'),
            'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
    }


    public function appendColumns(): array
    {
        return [
            Column::make('Aksi')
                ->collapseOnMobile()
                ->label(fn($row) => view('components.table.actions', [
                    'actions' => [
                        [
                            'color' => 'warning text-white',
                            'icon' => 'fa-location-dot',
                            'wire:click' => "findLocation('$row->id')",
                            'active' => true,

                        ],
                        [
                            'icon' => 'fa-eye',
                            'wire:click' => "detail('$row->id')",
                            'color' => 'primary text-white',
                            'active' => true,
                        ],
                        [
                            'icon' => 'fa-trash-can',
                            'wire:click' => "delete('$row->id')",
                            'color' => 'danger text-white',
                            'active' => $row->user_id == auth()->user()->id ? true :(auth()->user()->hasRole('admin') ? true : false),
                        ]
                    ]
                ])),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Nama", "nama")
                ->searchable()
                ->sortable(),
            DateColumn::make("Tgl Lahir", "tgl_lahir")
                ->inputFormat('Y-m-d')
                ->outputFormat('d M Y')
                ->sortable(),
            Column::make("Umur", "umur")
                ->searchable()
                ->sortable(),
            Column::make("lat")->hideIf(true),
            Column::make("lng")->hideIf(true),
            Column::make("Kordinat")
                ->label(fn($row) => view('components.table.badge', [
                    'icon' => $row->lat && $row->lng ? 'fa fa-check-circle' : 'fa fa-times-circle',
                    'slot' => '',
                    'class' => $row->lat && $row->lng ? 'success text-white' : 'danger text-white',
                ])),
            DateColumn::make("Tgl Pendataan", "created_at")
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d M Y')
                ->sortable(),
            Column::make("Pendata", 'pendata.name')
                ->searchable()
                ->sortable(),
            Column::make("Pesan", "note")
                ->format(function ($val) {
                    if ($val) {
                        return view('components.table.popover', [
                            'icon' => 'fa fa-question-circle',
                            'message' => $val,
                            'title' => ''
                        ]);
                    } else {
                        return '-';
                    }
                })
                ->searchable()
                ->sortable(),
            Column::make("Status", "status")
                ->format(fn($value, $row, Column $column) => view('components.table.badge', [
                    'class' => ($value == 'success' ? 'success' : ($value == 'pending' ? 'info' : 'danger')) . ' text-white text-uppercase',
                    'icon' => $value == 'success' ? 'fa-check' : ($value == 'pending' ? 'fa-hourglass-half' : 'fa-xmark'),
                    'slot' => $value == 'success' ? 'Dikonfirmasi' : ($value == 'pending' ? 'Proses' : ($value == 'reject' ? 'Ditolak' : 'Meninggal')),
                ]))
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'Semua',
                    'success' => 'Dikonfirmasi',
                    'pending' => 'Proses',
                    'reject' => 'Ditolak',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('status', $value);
                }),
        ];
    }

    public function findLocation($id)
    {
        $lansia = Lansia::find($id);
        if ($lansia->lng && $lansia->lat) {
            $this->dispatch('markerUpdate', $lansia);
        } else {
            $this->dispatch('markerError', ['message' => 'Lokasi tidak ditemukan!']);
        }
    }

    #[On('confirmDelete')]
    public function delete($id, $status = false)
    {
        if ($status) {
            $lansia = Lansia::find($id);
            $lansia->delete();
            $this->dispatch('miniNotif', ['message' => 'Data berhasil dihapus.']);
            return;
        }

        // $lansia->delete();
        $this->dispatch('popupDelete', ['id' => $id, 'status' => true]);
    }

    public function detail($id)
    {
        $this->redirectRoute('lansia.detail', ['id' => $id]);
    }
}
