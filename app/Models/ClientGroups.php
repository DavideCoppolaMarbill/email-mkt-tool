<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGroups extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
       'id', 'group_name', 'user_id',
    ];
}
