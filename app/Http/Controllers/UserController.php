<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return \view('pages.users.index');
    }

    public function show(User $user)
    {
        return \view('pages.users.show', [
            'user' => $user
        ]);
    }
}
