<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class ClientGroups extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
       'id', 'group_name', 'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            // Filter groups based on the currently authenticated user
            $builder->where('user_id', auth()->id());
        });
    }
}
