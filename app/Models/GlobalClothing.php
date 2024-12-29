<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalClothing extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'id' => 'integer',
    ];

    public function savedAdvice()
    {
        return $this->hasMany(SavedAdvice::class, 'clothing_id');
    }
}
