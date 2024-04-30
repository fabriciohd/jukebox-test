<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    CONST STATUS_PENDING = 1;
    CONST STATUS_DONE = 2;
    CONST STATUS_CANCELED = 3;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'date',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
