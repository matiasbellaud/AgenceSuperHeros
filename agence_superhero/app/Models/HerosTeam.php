<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerosTeam extends Model
{
    use HasFactory;
    protected $fillable = ['idHero','idTeam'];
}
