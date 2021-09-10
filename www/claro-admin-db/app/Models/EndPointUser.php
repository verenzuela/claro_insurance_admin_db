<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndPointUser extends Model
{
    use HasFactory;

    protected $table = 'end_point_user';
    protected $guarded = [];
}
