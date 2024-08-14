<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function billing()
    {
        return $this->hasOne(BillingSetting::class, 'entity_id', 'id');
    }
}
