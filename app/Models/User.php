<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Атрибути, які можна масово призначати.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role_id',
        'phone',
        'avatar',
        'status',
        'base_hourly_rate',
        'seasons_worked',
        'approved',
    ];

    /**
     * Атрибути, які повинні бути приховані.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Атрибути, які слід перетворювати.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Додаткові поля, які будуть включені в модель
     */
    protected $appends = ['name', 'role'];
    
    /**
     * Взаємозв'язок з моделлю ролей
     */
    public function roleRelation()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    /**
     * Віртуальний атрибут name
     * Повертає full_name або запасне значення
     */
    public function getNameAttribute()
    {
        return $this->full_name ?? 'Користувач';
    }
    
    /**
     * Віртуальний атрибут role
     * Перетворює role_id у строкове представлення ролі
     */
    public function getRoleAttribute()
    {
        try {
            $roleMap = [
                1 => 'admin',
                2 => 'operative',
                3 => 'lifeguard'
            ];
            
            // Для відлагодження
            if (app()->isLocal()) {
                Log::info('Getting role for user', [
                    'user_id' => $this->id,
                    'role_id' => $this->role_id,
                    'mapped_role' => $roleMap[$this->role_id] ?? 'unknown'
                ]);
            }
            
            return $roleMap[$this->role_id] ?? 'lifeguard';
        } catch (\Exception $e) {
            // Для відлагодження
            if (app()->isLocal()) {
                Log::error('Error getting role', [
                    'user_id' => $this->id,
                    'error' => $e->getMessage()
                ]);
            }
            return 'lifeguard'; // За замовчуванням
        }
    }
    
    /**
     * Перевірка, чи користувач є адміністратором
     */
    public function isAdmin()
    {
        return $this->role_id == 1;
    }
    
    /**
     * Перевірка, чи користувач є оперативним працівником
     */
    public function isOperative()
    {
        return $this->role_id == 2;
    }
    
    /**
     * Перевірка, чи користувач є рятувальником
     */
    public function isLifeguard()
    {
        return $this->role_id == 3;
    }
    
    /**
     * Перевірка наявності дозволу
     */
    public function hasPermission($permission)
    {
        if ($this->roleRelation && $this->roleRelation->permissions) {
            return isset($this->roleRelation->permissions[$permission]) && 
                   $this->roleRelation->permissions[$permission];
        }
        
        // Якщо немає ролі або дозволів, викликаємо стандартну логіку
        switch ($permission) {
            case 'admin_panel':
                return $this->isAdmin();
            case 'manage_users':
                return $this->isAdmin();
            case 'manage_shifts':
                return $this->isAdmin() || $this->isOperative();
            case 'view_map':
                return true; // Всі користувачі можуть переглядати карту
            default:
                return false;
        }
    }
    
    /**
     * Додаткові методи для роботи з системою
     */
    
    /**
     * Отримати зміни користувача
     */
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
    
    /**
     * Отримати активні зміни користувача (сьогоднішні)
     */
    public function activeShifts()
    {
        return $this->shifts()->whereDate('shift_date', now()->toDateString());
    }
}