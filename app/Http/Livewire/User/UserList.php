<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

use Mediconesystems\LivewireDatatables\BooleanColumn;

class UserList extends LivewireDatatable
{
    public $model = User::class;
    public $searchable = ['name'];
    public function builder()
    {
        return User::query()->where('role', '!=', User::ROLES['ADMIN']);
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')->linkTo('users'),
            Column::name('name')->label('Name'),
            Column::name('role')->label('Rule'),
            NumberColumn::name('files.id:count')->label('Files'),
        ];
    }
}
