<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\CountColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Spatie\Permission\Models\Role;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setOfflineIndicatorStatus(true);
        $this->setLoadingPlaceholderStatus(true);
        $this->setAdditionalSelects(['roles.id as id']);
        $this->setLoadingPlaceholderBlade('layout.panel.loader');
        $this->setEmptyMessage(__('No data available in table'));
        $this->setConfigurableAreas([
            'before-toolbar' => [
                'components.table.before-tools',
                ['toolbar' => $this->beforeToolbar()],
            ],
        ]);
    }

    /**
     * @return array
     * mengembalikan before toolbar
     */

    public function beforeToolbar(): array
    {
        return [
            ['url' => route('role.create'), 'title' => __('roles'), 'icon' => 'fa-circle-plus', 'color' => 'success'],
        ];
    }


    public function columns(): array
    {
        return [
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Guard", "guard_name")
                ->searchable()
                ->sortable(),
            Column::make('Jumlah Izin')
                ->label(fn($row) => view('components.table.badge', [
                    'class' => 'info text-white',
                    'icon' => 'fas fa-user-shield',
                    'slot' => $row->getPermissionNames()->count()
                ])),
            DateColumn::make("Dibuat", "created_at")
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d M Y')
                ->sortable(),
            ButtonGroupColumn::make(__('actions'))
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('edit')
                        ->title(fn() => __('edit'))
                        ->location(fn($row) => route('role.edit', $row->id))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'dropdown-item',
                                'icon' => 'fa-solid fa-pen-nib text-primary'
                            ];
                        }),
                    LinkColumn::make('delete')
                        ->title(fn() => __('delete'))
                        ->location(fn($row) => route('role.delete', $row->id))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'dropdown-item',
                                'icon' => 'fa-solid fa-trash-can text-danger',
                                'confirm' => true
                            ];
                        }),
                ])
        ];
    }
}
