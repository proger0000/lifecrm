<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Log;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request)
    {
        return parent::version($request);
    }

    public function share(Request $request)
    {
        // Відлагодження - запишемо в лог інформацію про користувача
        if ($request->user()) {
            Log::info('User data in Inertia middleware:', [
                'id' => $request->user()->id,
                'full_name' => $request->user()->full_name,
                'email' => $request->user()->email,
                'role_id' => $request->user()->role_id,
                'attributes' => $request->user()->getAttributes(),
                'virtual_name' => $request->user()->name, // Віртуальний атрибут
                'virtual_role' => $request->user()->role, // Віртуальний атрибут
            ]);
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name, // Використовуємо віртуальний атрибут
                    'email' => $request->user()->email,
                    'role' => $request->user()->role, // Використовуємо віртуальний атрибут
                    'role_id' => $request->user()->role_id,
                    'avatar' => $request->user()->avatar,
                    'full_user_data' => $request->user()->getAttributes(), // Для відлагодження
                ] : null,
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'app' => [
                'name' => config('app.name'),
                'debug' => config('app.debug'),
            ],
        ]);
    }
}