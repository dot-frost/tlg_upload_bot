<?php

namespace App\Http\Livewire\User;

use App\Models\File;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class FileList extends LivewireDatatable
{

    public $model = File::class;

    public User $user;

    public function builder()
    {
        return $this->user->files();
    }

    public function columns()
    {
        return [
            Column::callback(['path', 'name'], function ($path, $name) {
                return view('datatables::link', [
                    'href' => \Storage::disk('public')->url($path),
                    'slot' => $name
                ]);
            })->label('Name'),

        ];
    }
}
