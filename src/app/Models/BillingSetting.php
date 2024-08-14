<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingSetting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function stamp(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('category', 'stamp');
    }

    public function signature(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('category', 'signature');
    }

    public function logo(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('category', 'logo');
    }
}
