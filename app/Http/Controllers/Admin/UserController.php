<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Відображає список користувачів:
     * - нові заявки (approved = false),
     * - зареєстровані (approved = true).
     */
    public function index()
    {
        // Користувачі, які ще не схвалені
        $newUsers = User::where('approved', false)->get();
        // Користувачі, які схвалені
        $approvedUsers = User::where('approved', true)->get();

        return Inertia::render('Admin/Users/Index', [
            'newUsers' => $newUsers,
            'approvedUsers' => $approvedUsers,
        ]);
    }

    /**
     * Форма редагування даних користувача.
     *
     * @param  User  $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Оновлення даних користувача.
     * Після оновлення користувач стає схваленим (approved = true).
     *
     * @param  Request  $request
     * @param  User     $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // Валідація вхідних даних
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role'  => 'required|in:admin,operative,lifeguard',
        ]);

        // Примусово схвалюємо користувача
        $data['approved'] = true;

        // Оновлюємо дані в моделі
        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Дані користувача оновлено.');
    }

    /**
     * Окремий метод для схвалення користувача.
     * Якщо ви хочете схвалювати та призначати роль одним запитом.
     *
     * @param  Request  $request
     * @param  User     $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,operative,lifeguard',
        ]);

        $user->update([
            'role'     => $data['role'],
            'approved' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Користувача схвалено та роль оновлено.');
    }
}
