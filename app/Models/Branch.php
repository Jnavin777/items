<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function respUser()
    {
        return $this->belongsTo(User::class,'resp_user_id','id');
    }
}
