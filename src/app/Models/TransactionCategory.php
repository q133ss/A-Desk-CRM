<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function transations()
    {
        return $this->hasMany(TransactionItem::class, 'group_id', 'id')
            ->orderBy('position', 'asc');
    }
}
