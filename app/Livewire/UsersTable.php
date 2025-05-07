<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Spatie\Permission\Models\Role;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;
    protected $roleModel = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setOfflineIndicatorStatus(true);
        $this->setLoadingPlaceholderStatus(true);
        $this->setAdditionalSelects(['users.id as id']);
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
            ['url' => route('users.create'), 'title' => __('users'), 'icon' => 'fa-circle-plus', 'color' => 'success'],
        ];
    }


    public function columns(): array
    {
        return [
            Column::make(__('Name'), "name")
                ->sortable(),
            Column::make(__('Email'), "email")
                ->sortable(),
            Column::make(__('roles'), "name")
                ->format(fn($value, $row, Column $column) => view('components.table.badge', [
                    'class' => 'primary',
                    'icon' => 'fa-solid fa-user-tie',
                    'slot' => $row->getRoleNames()->first()
                ]))
                ->sortable(),
            DateColumn::make(__('Created'), "created_at")
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
                        ->location(fn($row) => route('users.edit', $row->id))
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
                                'data-confirm-delete' => 'true',
                                'class' => 'dropdown-item',
                                'icon' => 'fa-solid fa-trash-can text-danger',
                            ];
                        }),
                ])
        ];
    }

    public function filters(): array
    {
        $roles = $this->roleModel::all()->pluck('name', 'id')->toArray();

        return [
            SelectFilter::make(__('roles'), 'roles')
                ->options(array_merge(['' => 'Semua'], $roles))
                ->filter(function (Builder $builder, string $value) {
                    $builder->when($value, function (Builder $builder) use ($value) {
                        $builder->whereHas('roles', function ($query) use ($value) {
                            $query->where('name', $value);
                        });
                    });
                })
        ];
    }
}