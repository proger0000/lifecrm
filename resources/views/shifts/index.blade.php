@extends('app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Список смен</h1>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Пользователь</th>
                <th class="px-4 py-2 border">Пост</th>
                <th class="px-4 py-2 border">Дата смены</th>
                <th class="px-4 py-2 border">План. начало</th>
                <th class="px-4 py-2 border">План. окончание</th>
                <th class="px-4 py-2 border">Чек-ин</th>
                <th class="px-4 py-2 border">Чек-аут</th>
                <th class="px-4 py-2 border">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shifts as $shift)
            <tr>
                <td class="px-4 py-2 border">{{ $shift->id }}</td>
                <td class="px-4 py-2 border">{{ $shift->user->name ?? 'Не указано' }}</td>
                <td class="px-4 py-2 border">{{ $shift->post->name ?? 'Не указано' }}</td>
                <td class="px-4 py-2 border">{{ $shift->shift_date }}</td>
                <td class="px-4 py-2 border">{{ $shift->scheduled_start_time }}</td>
                <td class="px-4 py-2 border">{{ $shift->scheduled_end_time }}</td>
                <td class="px-4 py-2 border">{{ $shift->check_in_time ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $shift->check_out_time ?? '-' }}</td>
                <td class="px-4 py-2 border">
                    @if(is_null($shift->check_in_time))
                    <form action="{{ route('shifts.checkin', $shift) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Чек-ин</button>
                    </form>
                    @elseif(is_null($shift->check_out_time))
                    <form action="{{ route('shifts.checkout', $shift) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Чек-аут</button>
                    </form>
                    @else
                    Завершена
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <a href="{{ route('shifts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Назначить новую смену</a>
    </div>
</div>
@endsection
