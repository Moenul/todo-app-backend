<?php

namespace App\Models;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'is_completed',
        'priority_id',
    ];

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
}
