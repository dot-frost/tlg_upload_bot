<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();

        $admin->id = 1;
        $admin->name = 'Admin';
        $admin->password = Hash::make('password');
        $admin->email = 'admin@frost.com';
        $admin->role = User::ROLES['ADMIN'];
        $admin->save();
    }
}
