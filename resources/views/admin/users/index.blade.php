@extends('app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Управление пользователями</h1>

    <!-- Секция новых заявок -->
    <h2 class="text-xl font-semibold mb-4">Новые заявки</h2>
    @if($newUsers->isEmpty())
        <p>Нет новых заявок.</p>
    @else
        <table class="min-w-full bg-white border mb-8">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Имя</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Выбрать роль</th>
                    <th class="px-4 py-2 border">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($newUsers as $user)
                <tr>
                    <td class="px-4 py-2 border">{{ $user->id }}</td>
                    <td class="px-4 py-2 border">{{ $user->name }}</td>
                    <td class="px-4 py-2 border">{{ $user->email }}</td>
                    <td class="px-4 py-2 border">
                        <form action="{{ route('admin.users.approve', $user) }}" method="POST" id="approve-form-{{ $user->id }}">
                            @csrf
                            <select name="role" class="border rounded px-2 py-1 text-sm">
                                <option value="lifeguard">Лайфгард</option>
                                <option value="operative">Оперативный</option>
                                <option value="admin">Администратор</option>
                            </select>
                    </td>
                    <td class="px-4 py-2 border flex space-x-2">
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                            Одобрить
                        </button>
                        </form>
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                            Редактировать
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Секция одобренных пользователей -->
    <h2 class="text-xl font-semibold mb-4">Зарегистрированные пользователи</h2>
    @if($approvedUsers->isEmpty())
        <p>Нет одобренных пользователей.</p>
    @else
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Имя</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Роль</th>
                    <th class="px-4 py-2 border">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approvedUsers as $user)
                <tr>
                    <td class="px-4 py-2 border">{{ $user->id }}</td>
                    <td class="px-4 py-2 border">{{ $user->name }}</td>
                    <td class="px-4 py-2 border">{{ $user->email }}</td>
                    <td class="px-4 py-2 border">{{ ucfirst($user->role) }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                            Редактировать
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(session('success'))
        <div class="mt-6 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
