<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewUsersEndpoint extends Model
{
    use HasFactory;
    
    public $table = "users_endpoint";
}
