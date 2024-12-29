<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedAdvice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function globalClothing()
    {
        return $this->belongsTo(GlobalClothing::class, 'clothing_id');
    }

    public function userClothing()
    {
        return $this->belongsTo(UserClothing::class, 'clothing_id');
    }
}
