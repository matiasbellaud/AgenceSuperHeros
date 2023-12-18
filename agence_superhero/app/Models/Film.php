<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','title', 'year', 'description'];

    public function category()
    { 
        return $this->belongsTo(Category::class); 
    }
}
