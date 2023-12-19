<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerosPower extends Model
{
    use HasFactory;
    protected $fillable = ['idHero','idPower'];
}
