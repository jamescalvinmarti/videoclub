<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Review;

class Movie extends Model
{
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
