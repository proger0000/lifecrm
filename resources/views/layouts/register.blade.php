@extends('layouts.auth')

@section('content')
<h2 class="text-2xl font-bold text-center text-red-500 mb-6">Реєстрація</h2>

@if ($errors->any())
    <div class="mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-500">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-4">
        <label for="name" class="block text-gray-700">Ім'я</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
               class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500">
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700">Електронна адреса</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
               class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700">Пароль</label>
        <input id="password" type="password" name="password" required
               class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500">
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-gray-700">Підтвердіть пароль</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
               class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500">
    </div>

    <div>
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
            Зареєструватися
        </button>
    </div>
</form>

<div class="mt-4 text-center">
    <a href="{{ route('login') }}" class="text-red-500 hover:underline">
        Вже зареєстровані? Увійдіть тут.
    </a>
</div>
@endsection
