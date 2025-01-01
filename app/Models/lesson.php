<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    //! course has many lessons
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
}
