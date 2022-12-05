<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="flex justify-center items-center min-h-screen min-w-full bg-gray-300">
    <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">

            <form class="flex flex-col gap-3" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Your Email</span>
                    </label>
                    <label class="input-group input-group-vertical">
                        <input type="text" name="email" placeholder="info@site.com"
                            class="input input-bordered @error('email') input-error @enderror"
                            value="{{ old('email') }}" />
                    </label>
                    @error('email')
                        <label class="text-sm text-red-600">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Your Password</span>
                    </label>
                    <label class="input-group input-group-vertical">
                        <input name="password" type="password"
                            class="input input-bordered @error('password') input-error @enderror" />
                    </label>
                    @error('password')
                        <label class="text-sm text-red-600">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-control">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
