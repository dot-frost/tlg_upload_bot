<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Frost Upload</title>
    @livewireStyles
    @vite('resources/css/app.css')
</head>

<body class="bg-neutral">
    <div class="flex flex-col min-h-screen">

        <div class="navbar bg-base-100">
            <div class="flex-none">
                <label for="my-drawer" class="btn btn-ghost drawer-button lg:hidden"><i
                        class="material-icons mr-2">menu</i></label>
            </div>
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl">Frost Upload</a>
            </div>
            <div class="flex-none gap-2">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ Vite::asset('resources/images/admin.png') }}" />
                        </div>
                    </label>
                    <ul tabindex="0"
                        class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="drawer drawer-mobile">
            <input id="my-drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                @yield('main')
            </div>
            <div class="drawer-side">
                <label for="my-drawer" class="drawer-overlay"></label>
                <ul class="menu p-4 w-80 bg-base-100 text-base-content">
                    <li>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    @livewireScripts
</body>

</html>
