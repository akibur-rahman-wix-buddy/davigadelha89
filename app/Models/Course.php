<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    //! A course belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    //! A course has many lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    

}
