<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_id',
        'user_id'
    ];

    public function games()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
};
