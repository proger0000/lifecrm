<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Shift;

class LifeguardDashboardController extends Controller
{
    /**
     * Главная страница личного кабинета лайфгарда.
     */
    public function index()
    {
        $user = auth()->user();
        $shifts = Shift::where('user_id', $user->id)
            ->orderBy('shift_date', 'desc')
            ->get();

        return Inertia::render('Lifeguard/Dashboard', [
            'shifts' => $shifts,
        ]);
    }

    /**
     * Форма для заполнения отчёта по смене.
     */
    public function report(Shift $shift)
    {
        // Убедимся, что смена принадлежит текущему пользователю
        if ($shift->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        return Inertia::render('Lifeguard/Report', [
            'shift' => $shift,
        ]);
    }

    /**
     * Сохранение отчёта по смене.
     */
    public function storeReport(Request $request, Shift $shift)
    {
        if ($shift->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $data = $request->validate([
            'visitors'   => 'required|integer|min:0',
            'incidents'  => 'required|integer|min:0',
            'first_aid'  => 'required|integer|min:0',
            'violations' => 'required|integer|min:0',
        ]);

        $shift->update($data);

        return redirect()->route('lifeguard.dashboard')
            ->with('success', 'Звіт успішно збережено.');
    }
}
