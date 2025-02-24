@extends('app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Редактировать пользователя</h1>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Имя:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700">Роль:</label>
            <select name="role" id="role" class="w-full border px-3 py-2 rounded">
                <option value="lifeguard" {{ $user->role == 'lifeguard' ? 'selected' : '' }}>Лайфгард</option>
                <option value="operative" {{ $user->role == 'operative' ? 'selected' : '' }}>Оперативный</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Сохранить изменения
        </button>
    </form>
</div>
@endsection
