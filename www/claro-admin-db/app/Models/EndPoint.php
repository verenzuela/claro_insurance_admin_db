<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndPoint extends Model
{
    use HasFactory;

    protected $table = 'end_points';

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'end_point_user', 'end_point_id', 'user_id');
    }
}
