<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    // Поля, які можна оновлювати через масове призначення
    protected $fillable = [
        'user_id',
        'post_id',
        'shift_date',
        'scheduled_start_time',
        'scheduled_end_time',
        'check_in_time',
        'check_out_time',
        'visitors',
        'incidents',
        'first_aid',
        'violations',
    ];

    /**
     * Відношення: Зміна належить користувачу.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Відношення: Зміна належить посту.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
