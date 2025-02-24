@extends('app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Назначить смену</h1>
    <!-- Если валидация ошибок есть, выводим их -->
    @if($errors->any())
        <div class="mb-4">
            <ul class="list-disc text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('shifts.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Пользователь:</label>
            <select name="user_id" class="w-full border px-3 py-2 rounded" required>
                <!-- Передайте список пользователей в представление (например, переменная $users) -->
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Пост:</label>
            <select name="post_id" class="w-full border px-3 py-2 rounded" required>
                <!-- Передайте список постов в представление (например, переменная $posts) -->
                @foreach($posts as $post)
                    <option value="{{ $post->id }}">{{ $post->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Дата смены:</label>
            <input type="date" name="shift_date" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Планируемое время начала:</label>
            <input type="datetime-local" name="scheduled_start_time" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Планируемое время окончания:</label>
            <input type="datetime-local" name="scheduled_end_time" class="w-full border px-3 py-2 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить смену</button>
    </form>
</div>
@endsection
