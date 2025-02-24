@extends('layouts.auth')

@section('content')
<h2 class="text-2xl font-bold text-center text-red-500 mb-6">Увійти</h2>

@if ($errors->any())
    <div class="mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-500">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-gray-700">Електронна адреса</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
               class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700">Пароль</label>
        <input id="password" type="password" name="password" required
               class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500">
    </div>

    <div class="mb-4 flex items-center">
        <input type="checkbox" name="remember" id="remember" class="mr-2">
        <label for="remember" class="text-gray-700">Запам'ятати мене</label>
    </div>

    <div>
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
            Увійти
        </button>
    </div>
</form>

<div class="mt-4 text-center">
    <a href="{{ route('password.request') }}" class="text-red-500 hover:underline">
        Забули пароль?
    </a>
</div>

<div class="mt-2 text-center">
    <a href="{{ route('register') }}" class="text-red-500 hover:underline">
        Зареєструватися
    </a>
</div>
@endsection
