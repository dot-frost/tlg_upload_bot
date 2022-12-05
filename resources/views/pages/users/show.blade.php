@extends('layouts.main')
@section('main')
    <div class="m-6 card bg-base-100 shadow-xl">
        <div class="card-body">

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h1>Name: {{ $user->name }}</h1>
                    <h2>Rule: {{ Str::upper($user->role) }}</h2>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <livewire:user.file-list :user="$user" />
                </div>
            </div>
        </div>
    </div>
@endsection
