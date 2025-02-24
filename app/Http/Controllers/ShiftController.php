<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class ShiftController extends Controller
{
    /**
     * Відображає список змін для поточного користувача (або для адміністратора).
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user = auth()->user();

        // Якщо користувач не є адміном, показуємо лише його зміни
        if ($user->role !== 'admin') {
            $shifts = Shift::where('user_id', $user->id)
                ->orderBy('shift_date', 'desc')
                ->get();
        } else {
            // Для адміністратора можна показувати всі зміни
            $shifts = Shift::orderBy('shift_date', 'desc')->get();
        }

        return Inertia::render('Shifts/Index', [
            'shifts' => $shifts,
        ]);
    }

    /**
     * Відображає форму створення нової зміни.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Можна передати додаткові дані, наприклад, список користувачів або постів
        return Inertia::render('Shifts/Create');
    }

    /**
     * Зберігає нову зміну.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валідація даних форми
        $data = $request->validate([
            'user_id'              => 'required|exists:users,id',
            'post_id'              => 'required|exists:posts,id',
            'shift_date'           => 'required|date',
            'scheduled_start_time' => 'required|date_format:Y-m-d\TH:i',
            'scheduled_end_time'   => 'required|date_format:Y-m-d\TH:i|after:scheduled_start_time',
        ]);

        Shift::create($data);

        return redirect()->route('shifts.index')
            ->with('success', 'Зміну успішно створено.');
    }

    /**
     * Фіксує час початку зміни (Чек-ін).
     *
     * @param  Shift  $shift
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkIn(Shift $shift)
    {
        // Записуємо поточний час як час чек-іну
        $shift->check_in_time = Carbon::now();
        $shift->save();

        return redirect()->route('shifts.index')
            ->with('success', 'Чек-ін зафіксовано.');
    }

    /**
     * Фіксує час завершення зміни (Чек-аут).
     *
     * @param  Shift  $shift
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkOut(Shift $shift)
    {
        // Записуємо поточний час як час чек-ауту
        $shift->check_out_time = Carbon::now();
        $shift->save();

        return redirect()->route('shifts.index')
            ->with('success', 'Чек-аут зафіксовано.');
    }
}
