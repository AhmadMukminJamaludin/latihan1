<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'date',
        'users_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
