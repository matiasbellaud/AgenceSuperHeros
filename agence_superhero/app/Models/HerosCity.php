<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerosCity extends Model
{
    use HasFactory;
    protected $fillable = ['idHero','idCity'];
}
