<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDirection extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(BusinessDirection::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BusinessDirection::class, 'parent_id');
    }
}
