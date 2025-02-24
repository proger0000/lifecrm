@extends('app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Личный кабинет лайфгарда</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($shifts->isEmpty())
        <p>Смен пока нет.</p>
    @else
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Дата смены</th>
                    <th class="px-4 py-2 border">План. начало</th>
                    <th class="px-4 py-2 border">План. окончание</th>
                    <th class="px-4 py-2 border">Чек-ин</th>
                    <th class="px-4 py-2 border">Чек-аут</th>
                    <th class="px-4 py-2 border">Отчёт</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shifts as $shift)
                <tr>
                    <td class="px-4 py-2 border">{{ $shift->shift_date }}</td>
                    <td class="px-4 py-2 border">{{ $shift->scheduled_start_time }}</td>
                    <td class="px-4 py-2 border">{{ $shift->scheduled_end_time }}</td>
                    <td class="px-4 py-2 border">{{ $shift->check_in_time ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $shift->check_out_time ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        @if(is_null($shift->visitors))
                            <a href="{{ route('lifeguard.report', $shift) }}" class="text-blue-500 hover:underline">Заполнить отчёт</a>
                        @else
                            Заполнен
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
