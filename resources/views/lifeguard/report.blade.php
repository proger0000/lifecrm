@extends('app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Заполнить отчёт по смене ({{ $shift->shift_date }})</h1>

    <!-- Вывод ошибок валидации -->
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lifeguard.report.store', $shift) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="visitors" class="block text-gray-700">Количество посетителей:</label>
            <input type="number" name="visitors" id="visitors" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="incidents" class="block text-gray-700">Инциденты:</label>
            <input type="number" name="incidents" id="incidents" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="first_aid" class="block text-gray-700">Оказанная первая помощь:</label>
            <input type="number" name="first_aid" id="first_aid" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="violations" class="block text-gray-700">Замеченные нарушения:</label>
            <input type="number" name="violations" id="violations" class="w-full border px-3 py-2 rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить отчёт</button>
    </form>
</div>
@endsection
