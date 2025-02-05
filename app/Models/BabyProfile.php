<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BabyProfile extends Model
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
}
