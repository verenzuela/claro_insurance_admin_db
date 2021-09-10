<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewUsersWithoutEndpoint extends Model
{
    use HasFactory;
    
    public $table = "users_without_endpoint";
}
