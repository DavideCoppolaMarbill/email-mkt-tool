<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
       'user_id', 'first_name', 'last_name', 'email', 'sex', 'birthday',
    ];

    public function clientGroups(){
        return $this->belongsToMany(ClientGroups::class, 'client_groups', 'client_id', 'group_id');
    }
}
